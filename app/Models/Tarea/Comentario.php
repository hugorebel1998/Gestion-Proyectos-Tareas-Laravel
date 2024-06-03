<?php

namespace App\Models\Tarea;

use Illuminate\Database\Eloquent\Casts\Attribute;
use MongoDB\Laravel\Eloquent\Model;

class Comentario extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'tarea_comentarios';

    protected $fillable = [
        'tarea_id',
        'usuario_id',
        'comentario',
    ];


    protected function comentario(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtolower($value)
        );
    }
}
