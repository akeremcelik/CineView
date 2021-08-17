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


Route::group(['prefix' => 'auth'], function() {
    Route::post('/register', 'App\Http\Controllers\Api\AuthController@register');
    Route::post('/login', 'App\Http\Controllers\Api\AuthController@login');
});

Route::middleware('auth:api')->group(function() {
    Route::resource('/city', 'App\Http\Controllers\Api\CityController');
    Route::resource('/cinema', 'App\Http\Controllers\Api\CinemaController');
    Route::resource('/film', 'App\Http\Controllers\Api\FilmController');
    Route::resource('/visionfilm', 'App\Http\Controllers\Api\VisionFilmController');
    Route::resource('/ticket', 'App\Http\Controllers\Api\TicketController');
    
    Route::get('/user', function (Request $request) { return $request->user(); });
});
