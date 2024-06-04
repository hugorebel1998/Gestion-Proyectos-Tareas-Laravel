<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'tareas', 'middleware' => 'authMain'], function () {

    Route::post('/{tarea}/comentario', 'TareaController@crearComentario')->name('crear-comentario');
});
