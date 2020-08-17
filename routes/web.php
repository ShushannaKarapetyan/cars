<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/cars/create', 'CarsController@create')->name('cars.create');
    Route::post('/cars', 'CarsController@store')->name('cars.store');
});

Route::get('/cars', 'CarsController@index')->name('cars.index');
