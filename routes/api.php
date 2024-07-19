<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ReponseController;
use App\Http\Controllers\QuestionController;
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
    });
// Google URL
Route::prefix('google')->name('google.')->group(function () {
    Route::get('login', [GoogleController::class, 'loginWithGoogle'])->name('login');
    Route::any('callback', [GoogleController::class, 'callbackFromGoogle'])->name('callback');
});

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
