<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use MongoDB\Laravel\Eloquent\Model;


class Proyecto extends Model
{
    const ESTATUS_EN_CURSO   = 'en_curso';
    const ESTATUS_PAUSA      = 'pausa';
    const ESTATUS_COMPLETADA = 'completada';
    const ESTATUS_CANCELADA  = 'cancelada';


    protected $connection = 'mongodb';

    protected $collection = 'proyectos';

    protected $fillable = [
        'usuario_id',
        'nombre',
        'descripcion',
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
