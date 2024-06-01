<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Usuario extends Model
{

    const ESTATUS_ACTIVO   = 'activo';
    const ESTATUS_INACTIVO = 'inactivo';

    protected $connection = 'mongodb';

    protected $fillable = [
        'nombre',
        'paterno',
        'materno',
        'username',
        'email',
        'password',
        'estatus',
    ];

    protected $attributes = [
        'estatus' => self::ESTATUS_ACTIVO
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at',
        'password',
    ];

    protected $casts = [
        'password' => 'hashed'
    ];
}
