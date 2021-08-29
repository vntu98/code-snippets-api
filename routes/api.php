<?php

use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\MeController;
use App\Http\Controllers\Auth\SignOutController;
use App\Http\Controllers\Me\SnippetController as MeSnippetController;
use App\Http\Controllers\Snippets\SnippetController;
use App\Http\Controllers\Snippets\StepController;
use App\Http\Controllers\Users\SnippetController as UsersSnippetController;
use App\Http\Controllers\Users\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('signin', SignInController::class);
    Route::post('signout', SignOutController::class);
    Route::get('me', MeController::class);
});

Route::group(['prefix' => 'snippets'], function () {
    Route::get('', [SnippetController::class, 'index']);
    Route::post('', [SnippetController::class, 'store']);
    Route::delete('{snippet}', [SnippetController::class, 'destroy']);
    Route::get('{snippet}', [SnippetController::class, 'show']);
    Route::patch('{snippet}', [SnippetController::class, 'update']);

    Route::patch('{snippet}/steps/{step}', [StepController::class, 'update']);
    Route::post('{snippet}/steps', [StepController::class, 'store']);
    Route::delete('{snippet}/steps/{step}', [StepController::class, 'destroy']);
});

Route::group(['prefix' => 'users/{user}'], function () {
    Route::get('', [UserController::class, 'show']);
    Route::patch('', [UserController::class, 'update']);
    Route::get('snippets', [UsersSnippetController::class, 'index']);
});

Route::group(['prefix' => 'me'], function () {
    Route::get('snippets', [MeSnippetController::class, 'index']);
});
