<?php

Route::get('/', function () {
    return view('welcome');
});

// pages
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/kontakt', 'HomeController@contact')->name('contact');
Route::get('/sortiment', 'HomeController@products')->name('products');
Route::post('/cookie', 'HomeController@cookie');
Route::get('/objednat', 'OrderController@index');
Route::post('/prepare', 'OrderController@prepare');
Route::get('/objednavka', 'OrderController@cart');

// cart
Route::post('/objednavka/{id}', 'OrderController@addToCart')->name('add');
Route::post('/order', 'OrderController@order');
Route::post('/remove/{id}', 'OrderController@removeFromCart');

Route::post('/emails/contact', 'EmailController@contact');

// administration
Auth::routes();
Route::get('/administrace', 'AdministrativeController@index');
Route::get('/administrace/{id}/upravit', 'SweetController@edit');
Route::post('/administrace/update', 'SweetController@update');
Route::post('/administrace/delete', 'SweetController@deactivate');
Route::get('/administrace/novy', 'SweetController@create');
Route::post('/administrace/store', 'SweetController@store');

Route::get('/administrace/{id}', 'AdministrativeController@detail');
Route::post('/administrace/deactivate', 'AdministrativeController@deactivate');
Route::post('/administrace/buy', 'AdministrativeController@buy');
