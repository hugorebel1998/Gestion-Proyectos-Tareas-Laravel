<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use MongoDB\Laravel\Eloquent\Model;

class Tarea extends Model
{

    protected $connection = 'mongodb';

    protected $collection = 'tareas';

    protected $fillable = [
        'proyecto_id',
        'usuario_id',
        'nombre',
        'descripcion',
        'prioridad',
        'estatus',
        'fecha_inicio',
        'fecha_termino',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_termino' => 'date',
    ];

    protected $hidden = [
        'updated_at',
    ];

    protected function nombre(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtolower($value)
        );
    }

    protected function descripcion(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtolower($value)
        );
    }
}
