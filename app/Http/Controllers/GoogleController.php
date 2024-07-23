<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function loginWithGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function callbackFromGoogle()
    {
        try {
            Log::info('Attempting to get user from Google...');

            $user = Socialite::driver('google')->user();

            Log::info('User retrieved from Google: ', ['user' => $user]);

            dd($user);
            //check user email if already there
            $is_user = User::where('email',$user->getEmail())->first();
            if(!$is_user){
                Log::info('User not found, creating a new user.');
                $saveUser = User::updateOrCreate([
                    'google_id' => $user->getId(),
            ],[
                'name'=>$user->getName(),
                'email'=>$user->getEmail(),
                'password'=>Hash::make($user->getName().'@'.$user->getId())

            ]);

            }else{
                Log::info('User found, updating google_id.');
                $saveUser = User::where('email',$user->getEmail())->update([
                    'google_id' => $user->getId(),
                ]);
                $saveUser = User::where('email',$user->getEmail())->first();
            }
            Log::info('Logging in the user...');
            Auth::loginUsingId($saveUser->id);
            return redirect()->route('/');
        } catch (\Throwable $th) {
            Log::error('Google callback error 5: ' . $th->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
