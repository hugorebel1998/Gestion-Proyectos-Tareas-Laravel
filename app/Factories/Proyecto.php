<?php

namespace App\Factories;

use App\Models\Proyecto as ModelsProyecto;

class Proyecto
{
    public static function select(string|null $proyecto_id)
    {
        if (empty($proyecto_id))
            return ModelsProyecto::all();

        return ModelsProyecto::findOrFail($proyecto_id);
    }

    public static function create(array $proyecto)
    {
        return $proyecto;
    }
}
