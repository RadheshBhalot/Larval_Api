<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::get('/register',[UserController::class,'register']);
Route::post('/register',[UserController::class,'register']);
Route::get('/login',[UserController::class,'login'])->name('login');
Route::post('/login',[UserController::class,'login']);  

Route::middleware('auth:sanctum')->group(function() {
Route::get('/home',[UserController::class,'home']);
Route::get('/update',[UserController:: class,'update']);
Route::post('/update/{id}',[UserController:: class,'update']);
Route::delete('/delete/{id}',[UserController::class,'delete']);

    Route::get('/postss', [PostController::class,'index']);
    Route::post('/posts', [PostController::class,'store']);
});
