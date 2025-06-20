<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookApiController;
use App\Http\Controllers\Api\AuthorApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\BorrowApiController;
use Illuminate\Http\Request;

use App\Http\Controllers\AuthController;

Route::prefix('auth')->middleware('api')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']); // Добавим регистрацию
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    Route::get('me', [AuthController::class, 'me'])->middleware('auth:api'); // GET вместо POST для получения данных пользователя
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::apiResource('books', BookApiController::class);
Route::apiResource('authors', AuthorApiController::class);
Route::apiResource('categories', CategoryApiController::class);
Route::apiResource('borrows', BorrowApiController::class);