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

Auth::routes();

Route::resource('menu', 'MenuController');
Route::resource('transaction', 'TransactionController');
Route::resource('transaction_detail', 'TransactionDetailController');

Route::post('/store_transaction', 'TransactionController@storeTransaction');
Route::get('/transaction_detail/{id}/show_transaction', 'TransactionDetailController@showTransaction')->name('transaction_detail.show_transaction');
Route::get('/', 'HomeController@index')->name('home')->middleware('auth');
