<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::prefix('auth')->middleware('api')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']); // Добавим регистрацию
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    Route::get('me', [AuthController::class, 'me'])->middleware('auth:api'); // GET вместо POST для получения данных пользователя
});

// Пример маршрута для проверки пользователя (можно оставить или убрать)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api'); // Заменили auth:sanctum на auth:api