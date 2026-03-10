<?php

use Illuminate\Support\Facades\Route;
use App\Api\V1\Controllers\SignUpController;
use App\Api\V1\Controllers\LoginController;
use App\Api\V1\Controllers\ForgotPasswordController;
use App\Api\V1\Controllers\ResetPasswordController;
use App\Api\V1\Controllers\LogoutController;
use App\Api\V1\Controllers\RefreshController;
use App\Api\V1\Controllers\UserController;

Route::prefix('v1')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('signup', [SignUpController::class, 'signUp']);
        Route::post('login', [LoginController::class, 'login']);

        Route::post('recovery', [ForgotPasswordController::class, 'sendResetEmail']);
        Route::post('reset', [ResetPasswordController::class, 'resetPassword']);

        Route::post('logout', [LogoutController::class, 'logout']);
        Route::post('refresh', [RefreshController::class, 'refresh']);

        Route::get('me', [UserController::class, 'me']);
    });

    Route::middleware(['jwt.auth'])->group(function () {

        Route::get('protected', function () {
            return response()->json([
                'message' => 'Access to protected resources granted! You are seeing this text as you provided the token correctly.',
            ]);
        });

        Route::get('refresh', function () {
            return response()->json([
                'message' => 'By accessing this endpoint, you can refresh your access token at each request. Check out this response headers!',
            ]);
        })->middleware('jwt.refresh');
    });

    Route::get('hello', function () {
        return response()->json([
            'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.',
        ]);
    });
});
