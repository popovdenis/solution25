<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserBookController;
use Illuminate\Http\Request;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
});

Route::middleware('auth:api')->group(function () {
    // owner books (1:N)
    Route::apiResource('books', BookController::class);

    // bindings (many-to-many)
    Route::get('users/{user}/books', [UserBookController::class, 'index']);
    Route::get('users/{user}/books/available', [UserBookController::class, 'available']);
    Route::post('users/{user}/books', [UserBookController::class, 'store']);
    Route::delete('users/{user}/books/{book}', [UserBookController::class, 'destroy']);

    // aliases
    Route::get('me/books',             [UserBookController::class, 'indexMe']);
    Route::get('me/books/available',   [UserBookController::class, 'availableMe']);
    Route::post('me/books',            [UserBookController::class, 'storeMe']);
    Route::delete('me/books/{book}',   [UserBookController::class, 'destroyMe']);
});
