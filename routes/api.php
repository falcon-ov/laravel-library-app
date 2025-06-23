<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookApiController;
use App\Http\Controllers\Api\AuthorApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\BorrowApiController;

Route::middleware('auth:api')->group(function () {
    Route::resource('books', BookApiController::class);
    Route::resource('authors', AuthorApiController::class);
    Route::resource('categories', CategoryApiController::class);
    Route::resource('borrows', BorrowApiController::class);
});