<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class GoogleAuthController extends Controller
{
    public function handleGoogleAuth(Request $request)
    {
        Log::info('handleGoogleAuth method called');

        $code = $request->input('code');
        Log::info('Google Auth Code Received:', ['code' => $code]);

        // Échanger le code d'autorisation contre un token d'accès
        $response = Http::post('https://oauth2.googleapis.com/token', [
            'code' => $code,
            'client_id' => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'redirect_uri' => config('services.google.redirect'),
            'grant_type' => 'authorization_code',
        ]);

        Log::info('Token Exchange Response:', $response->json());

        if ($response->failed()) {
            Log::error('Failed to exchange authorization code:', ['response' => $response->json()]);
            return response()->json([
                'error' => 'Failed to exchange authorization code',
                'details' => $response->json(),
            ], 500);
        }

        $data = $response->json();
        Log::info('Google Auth Response:', $data);

        // Utiliser le token d'accès pour obtenir les informations de l'utilisateur
        $userResponse = Http::withToken($data['access_token'])->get('https://www.googleapis.com/oauth2/v2/userinfo');

        if ($userResponse->failed()) {
            Log::error('Failed to fetch user info:', ['response' => $userResponse->json()]);
            return response()->json([
                'error' => 'Failed to fetch user info',
                'details' => $userResponse->json(),
            ], 500);
        }

        $userData = $userResponse->json();
        Log::info('Google User Data:', $userData);

        // Enregistrer ou mettre à jour l'utilisateur dans la base de données
        $user = User::updateOrCreate(
            ['google_id' => $userData['id']],
            [
                'firstname' => $userData['given_name'],
                'lastname' => $userData['family_name'],
                'email' => $userData['email'],
                'token' => $data['access_token'],
            ]
        );

        return response()->json([
            'message' => 'User successfully authenticated and stored.',
            'user' => $user,
            'google_response' => $data, // Retourner les données de réponse de Google
            'user_info' => $userData,   // Retourner les informations utilisateur de Google
        ]);
    }
}
