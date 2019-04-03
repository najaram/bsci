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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::namespace('Admin')->middleware(['web', 'auth'])->group(function () {

    Route::get('/invoice', 'InvoiceController@index');
    Route::get('/invoice/list', 'InvoiceController@list')->name('invoice.list');
    Route::get('/invoice/{invoice}/edit', 'InvoiceController@edit');
    Route::get('/invoice/create', 'InvoiceController@create');
    Route::post('/invoice', 'InvoiceController@store');
    Route::get('/invoice/{invoice}', 'InvoiceController@show');
    Route::get('/invoice/{invoice}/show', 'InvoiceController@view');
    Route::put('/invoice/{invoice}', 'InvoiceController@update');
    Route::delete('/invoice/{invoice}', 'InvoiceController@destroy');

    Route::get('/products', 'ProductController@index');
    Route::get('/products/{product}', 'ProductController@show');
});
