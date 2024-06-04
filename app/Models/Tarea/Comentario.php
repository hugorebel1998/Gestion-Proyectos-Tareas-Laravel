<?php

namespace App\Models\Tarea;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{

    protected $table = 'tarea_comentarios';

    protected $fillable = [
        'tarea_id',
        'usuario_id',
        'comentario',
    ];

    use HasUlids;


    protected function comentario(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtolower($value)
        );
    }
}
