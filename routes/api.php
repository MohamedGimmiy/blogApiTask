<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
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

Route::apiResource('/posts', PostController::class)->except(['store','destory','update']);

Route::post('/login',[RegisterController::class, 'login']);
Route::post('/register',[RegisterController::class, 'register']);
Route::get('/count', [PostController::class, 'count']);

Route::middleware('auth:sanctum')->group(function (){
    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/posts/{post}', [PostController::class, 'update'])->middleware('can:update,post');
    Route::delete('/posts/{post}',[PostController::class, 'destroy'])->middleware('can:delete,post');
    Route::post('/logout',[RegisterController::class, 'logout']);
    Route::get('/user',[RegisterController::class, 'getUser']);


});
