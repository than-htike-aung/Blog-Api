<?php

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/test', function(){
//   return ResponseHelper::fail("validate error");
// });

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function(){
    Route::get('/profile', [ProfileController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/category/create', [CategoryController::class, 'create']);
    Route::post('/category/edit/{id}', [CategoryController::class, 'edit']);
    Route::post('/category/update/{id}', [CategoryController::class, 'edit']);
    Route::post('/category/delete/{id}', [CategoryController::class, 'delete']);

    Route::get('post', [PostController::class, 'index']);
    Route::post('post', [PostController::class, 'create']);
    Route::get('post/{id}', [PostController::class, 'show']);
    Route::post('post/delete/{id}', [PostController::class, 'delete']);
});