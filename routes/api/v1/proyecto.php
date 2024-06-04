<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'proyectos', 'middleware' => 'authMain'], function () {

    Route::get('/', 'ProyectoController@listar')->name('listar');
    Route::get('/restablecer/{proyecto}', 'ProyectoController@restablecer')->name('restablecer');
    Route::get('/{proyecto}', 'ProyectoController@listar')->name('mostrar');
    Route::post('/', 'ProyectoController@crear')->name('crear');
    Route::put('/{proyecto}', 'ProyectoController@actualizar')->name('actualizar');
    Route::delete('/{proyecto}', 'ProyectoController@eliminar')->name('eliminar');

});
