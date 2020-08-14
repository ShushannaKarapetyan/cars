<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/cars/create', 'CarsController@create');
    Route::post('/cars', 'CarsController@store');
});

Route::get('/cars', 'CarsController@index');
