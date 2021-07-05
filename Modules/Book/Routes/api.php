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

// Route::middleware('auth:api')->get('/book', function (Request $request) {
//     return $request->user();
// });

Route::namespace('Api')->group(function () {
    Route::prefix('v1/book')->group(function () {
        Route::post('/', 'BookController@getAllBook');
        Route::post('/detail', 'BookController@getBookDetail');
        Route::post('/pending', 'BookController@checkPending');
        Route::post('/borrowable', 'BookController@checkBorrowable');
        Route::post('/comment', 'BookController@getBookComment');
        Route::post('/createComment', 'BookController@createBookComment');
    });
});
