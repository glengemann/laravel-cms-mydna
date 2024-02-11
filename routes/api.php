<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'logIn']);
Route::post('/logout', [AuthController::class, 'logOut'])
    ->middleware('auth:sanctum');

Route::apiResource('/categories', CategoryController::class);

Route::apiResource('/comments', CommentController::class)
    ->only('index', 'show');
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/comments', CommentController::class)
        ->only('store', 'update', 'destroy');
    Route::patch('/comments/{comment}/status/{status}', [CommentController::class, 'status'])
        ->name('comments.status');
});

Route::apiResource('/posts', PostController::class)
    ->only('index', 'show');
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/posts', PostController::class)
        ->only('store', 'update', 'destroy');
});
