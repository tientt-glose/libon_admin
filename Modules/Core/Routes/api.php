<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/core', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')->group(function () {
    Route::prefix('v1')->group(function () {
        Route::post('login', 'UserController@login');
        Route::post('signup', 'UserController@signup');
    });

    Route::prefix('v1/organization')->group(function () {
        Route::post('/', 'OrganizationController@getAllOrgan');
    });
});
