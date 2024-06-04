<?php

namespace App\Factories\Tarea;

use App\Models\Tarea\Comentario as ModelsComentario;

class Comentario
{
    public static function create(array $comentario)
    {
        return ModelsComentario::create($comentario);
    }
}
