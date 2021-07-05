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

Route::prefix('book')->group(function () {
    Route::get('/', 'BookController@index');
});
Route::middleware(['web', 'auth'])->group(function () {

    Route::get('books/get', 'BookController@get')->name('book.books.get');
    Route::resource('books', 'BookController', ['as' => 'book'])->except(['show', 'destroy']);
    Route::get('books/delete/{id}', 'BookController@destroy')->name('book.books.destroy');

    Route::get('books/the-books/get', 'TheBookController@get')->name('book.books.the-books.get');
    Route::resource('books.the-books', 'TheBookController', ['as' => 'book'])->shallow()->except(['destroy']);
    Route::get('the-books/delete/{id}', 'TheBookController@destroy')->name('book.the-books.destroy');

    Route::resource('categories', 'CategoryController', ['as' => 'book'])->only(['index', 'store']);
    Route::post('categories/delete', 'CategoryController@deleteCategory')->name('book.categories.deleteCate');
    Route::post('categories/update', 'CategoryController@editCategory')->name('book.categories.editCate');

    Route::resource('publishers', 'PublisherController', ['as' => 'book'])->only(['index', 'store']);
    Route::post('publishers/delete', 'PublisherController@deletePublisher')->name('book.publishers.deletePub');
    Route::post('publishers/update', 'PublisherController@editPublisher')->name('book.publishers.editPub');
});
