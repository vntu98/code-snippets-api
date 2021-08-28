<?php

use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\MeController;
use App\Http\Controllers\Auth\SignOutController;
use App\Http\Controllers\Snippets\SnippetController;
use App\Http\Controllers\Snippets\StepController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('signin', SignInController::class);
    Route::post('signout', SignOutController::class);
    Route::get('me', MeController::class);
});

Route::group(['prefix' => 'snippets'], function () {
    Route::post('', [SnippetController::class, 'store']);
    Route::get('{snippet}', [SnippetController::class, 'show']);
    Route::patch('{snippet}', [SnippetController::class, 'update']);

    Route::patch('{snippet}/steps/{step}', [StepController::class, 'update']);
    Route::post('{snippet}/steps', [StepController::class, 'store']);
    Route::delete('{snippet}/steps/{step}', [StepController::class, 'destroy']);
});
