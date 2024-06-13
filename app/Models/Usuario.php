<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{

    const ESTATUS_ACTIVO   = 'activo';
    const ESTATUS_INACTIVO = 'inactivo';

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'paterno',
        'materno',
        'username',
        'email',
        'password',
        'estatus',
    ];

    protected $appends = [
        'nombre_completo'
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

    use HasUlids, SoftDeletes;

    protected function nombre(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
            set: fn ($value) => strtolower($value)
        );
    }

    protected function paterno(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
            set: fn ($value) => strtolower($value)
        );
    }

    protected function materno(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
            set: fn ($value) => strtolower($value)
        );
    }

    protected function nombreCompleto(): Attribute
    {
        return Attribute::make(
            get: fn () => implode(' ', array_map('ucfirst', array_filter([$this->nombre, $this->paterno, $this->materno])))
        );
    }

    public function proyectos()
    {
        return $this->hasMany(Proyecto::class, 'usuario_id')->orderBy('id', 'desc');
    }
}
