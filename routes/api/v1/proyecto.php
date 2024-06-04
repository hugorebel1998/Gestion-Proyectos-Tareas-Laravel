<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'proyectos', 'middleware' => 'authMain'], function () {

    Route::get('/', 'ProyectoController@listar')->name('listar');
    Route::get('/{proyecto}/mostrar', 'ProyectoController@listar')->name('mostrar');
    Route::post('/', 'ProyectoController@crear')->name('crear');
    Route::put('/{proyecto}', 'ProyectoController@actualizar')->name('actualizar');
    Route::delete('/{proyecto}', 'ProyectoController@eliminar')->name('eliminar');
    Route::get('/{proyecto}/restablecer', 'ProyectoController@restablecer')->name('restablecer');
   
    Route::get('/{proyecto}/tareas', 'ProyectoController@listarTareas')->name('listar-tareas');
    Route::post('/{proyecto}/tareas', 'ProyectoController@crearTarea')->name('crear-tarea');
    Route::put('/{proyecto}/tareas/{tarea}', 'ProyectoController@actualizarTarea')->name('actualizar-tarea');
    Route::delete('/{proyecto}/tareas/{tarea}', 'ProyectoController@eliminarTarea')->name('eliminar-tarea');

});
