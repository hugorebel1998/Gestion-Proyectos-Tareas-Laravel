<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use MongoDB\Laravel\Eloquent\SoftDeletes;
use MongoDB\Laravel\Relations\HasMany;
use MongoDB\Laravel\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{

    const ESTATUS_ACTIVO   = 'activo';
    const ESTATUS_INACTIVO = 'inactivo';

    protected $connection = 'mongodb';

    protected $collection = 'usuarios';

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

    use SoftDeletes;

    protected function nombre(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtolower($value)
        );
    }

    protected function paterno(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtolower($value)
        );
    }

    protected function materno(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtolower($value)
        );
    }

    protected function nombreCompleto(): Attribute
    {
        return Attribute::make(
            get: fn () => implode(' ', array_values([$this->nombre, $this->paterno, $this->materno]))
        );
    }

    public function proyectos(): HasMany
    {
        return $this->hasMany(Proyecto::class, 'usuario_id');
    }
}
