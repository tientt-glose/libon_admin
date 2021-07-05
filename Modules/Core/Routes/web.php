<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//todo: middleware web
Route::middleware(['web'])->group(function () {
    Route::get('/login', 'AdminController@login')->name('login');
    Route::post('/login', 'AdminController@loginPost')->name('login');

    //todo: hoi ve verify.role
    Route::middleware(['auth'])->group(function () {
        Route::get('/', 'DashboardController@index')->name('home');
        Route::get('/logout', 'AdminController@logout')->name('logout');
        Route::get('/user/check', 'UserController@checkUserInfo')->name('user.check');

        Route::get('/users', 'UserController@index')->name('user.index');
        Route::get('/users/get', 'UserController@get')->name('user.get');
        Route::get('/users/edit/{id}', 'UserController@edit')->name('user.edit');
        Route::post('/users/update/{id}', 'UserController@update')->name('user.update');
        Route::get('/users/create', 'UserController@create')->name('user.create');
        Route::post('/users/store', 'UserController@store')->name('user.store');
        Route::get('/users/delete/{id}', 'UserController@destroy')->name('user.destroy');
    });
});
