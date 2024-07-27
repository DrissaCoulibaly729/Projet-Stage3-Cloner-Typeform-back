<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ReponseController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\GoogleAuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('cors')->group(function () {
    Route::prefix('v1')->group(function () {
        // Routes pour User
        Route::get('users', [UserController::class, 'getAllUsers']);
        Route::get('users/{id}', [UserController::class, 'getUserById']);
        Route::post('users', [UserController::class, 'createUser']);
        Route::put('users/{id}', [UserController::class, 'updateUser']);
        Route::delete('users/{id}', [UserController::class, 'deleteUser']);

        // Routes pour Form
        Route::get('forms', [FormController::class, 'getAllForms']);
        Route::get('forms/{id}', [FormController::class, 'getFormById']);
        Route::post('forms', [FormController::class, 'createForm']);
        Route::put('forms/{id}', [FormController::class, 'updateForm']);
        Route::delete('forms/{id}', [FormController::class, 'deleteForm']);

        // Routes pour Question
        Route::get('questions', [QuestionController::class, 'getAllQuestions']);
        Route::get('questions/{id}', [QuestionController::class, 'getQuestionById']);
        Route::post('questions', [QuestionController::class, 'createQuestion']);
        Route::put('questions/{id}', [QuestionController::class, 'updateQuestion']);
        Route::delete('questions/{id}', [QuestionController::class, 'deleteQuestion']);

        // Routes pour Response
        Route::get('responses', [ReponseController::class, 'getAllReponses']);
        Route::get('responses/{id}', [ReponseController::class, 'getReponseById']);
        Route::post('responses', [ReponseController::class, 'createReponse']);
        Route::put('responses/{id}', [ReponseController::class, 'updateReponse']);
        Route::delete('responses/{id}', [ReponseController::class, 'deleteReponse']);

        // Auth routes
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

        Route::middleware('auth:sanctum')->get('/protected-route', function (Request $request) {
            return response()->json(['data' => 'This is protected data']);
        });
    });

    // Google authentication routes
    Route::prefix('google')->name('google.')->group(function () {
        Route::get('login', [GoogleController::class, 'loginWithGoogle'])->name('login');
        Route::any('callback', [GoogleController::class, 'callbackFromGoogle'])->name('callback');
        Route::post('google-auth', [GoogleAuthController::class, 'handleGoogleAuth'])->name('auth');
    });
});

// Route pour obtenir l'utilisateur authentifié
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
