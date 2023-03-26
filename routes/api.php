<?php

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
Route::post('/login', 'App\Http\Controllers\AuthController@login');
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('/user', 'App\Http\Controllers\AuthController@user');
    
    Route::post('/token', 'App\Http\Controllers\TokenController@create');
    Route::post('/token/check', 'App\Http\Controllers\TokenController@validateToken');
    Route::post('/token/refresh', 'App\Http\Controllers\TokenController@refreshToken');
});
Route::post('/register', 'App\Http\Controllers\AuthController@register')->middleware('jwt.auth');
