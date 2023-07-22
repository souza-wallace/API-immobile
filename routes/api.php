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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function(){
    Route::resource('realStates', 'App\Http\Controllers\Api\RealStateController');
    Route::resource('users', 'App\Http\Controllers\Api\UserController');
    Route::resource('categories', 'App\Http\Controllers\Api\CategoryController');
    Route::get('categories/{id}/real-states', 'App\Http\Controllers\Api\CategoryController@realState');
    Route::delete('photos/{id}', 'App\Http\Controllers\Api\RealStatePhotoController@remove');
    Route::put('set-thumb/{photId}/{realStateId}', 'App\Http\Controllers\Api\RealStatePhotoController@setThumb');
});


