<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    const ESTATUS = ['inicio', 'en_curso', 'pausa', 'completada', 'cancelada'];

    protected $table = 'proyectos';

    protected $fillable = [
        'usuario_id',
        'nombre',
        'descripcion',
        'estatus',
        'fecha_inicio',
        'fecha_termino',
    ];

    protected $hidden = [
        'updated_at',
    ];

    use HasUlids, SoftDeletes;

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
