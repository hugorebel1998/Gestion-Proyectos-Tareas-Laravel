<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {

    Route::post('/login', 'AuthController@inicio')->name('inicio-sesion');
    // Route::post('/refresh-token', 'AuthController@refrescarToken')->name('refresh-token');
});
