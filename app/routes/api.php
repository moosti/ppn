<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\CommentReactionController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('articles', ArticleController::class);

    Route::get('articles/{article}/comments', [CommentController::class, 'index']);
    Route::post('articles/{article}/comments', [CommentController::class, 'store']);

    Route::prefix('comments/{comment}')->group(function () {
        Route::get('', [CommentController::class, 'show']);
        Route::put('', [CommentController::class, 'update']);
        Route::delete('', [CommentController::class, 'destroy']);
        //reactions
        Route::post('like', [CommentReactionController::class, 'like']);
        Route::post('dislike', [CommentReactionController::class, 'dislike']);
    });
});
