<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\API\Auth\RegisterController;
use \App\Http\Controllers\API\Auth\AuthController;
use \App\Http\Controllers\API\Conversation\MessageController;
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
route::post('/login', [AuthController::class, 'login'])->name('api.login');
route::post('/register', [RegisterController::class, 'store'])->name('api.login');

Route::group(["middleware" => ['auth:sanctum']],function (){
    Route::post("message",[MessageController::class,"sendMessage"]);
    Route::post("getMessage",[MessageController::class,"getMessages"]);
});
