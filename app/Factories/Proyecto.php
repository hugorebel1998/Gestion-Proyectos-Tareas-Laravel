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
        return ModelsProyecto::create($proyecto);
    }

    public static function update(object $proyecto_db, array $proyecto)
    {
        $proyecto_db->fill($proyecto);

        $proyecto_db->save();

        return $proyecto_db;
    }

    public static function delete(string $proyecto_id)
    {
        $proyecto_db = ModelsProyecto::findOrFail($proyecto_id);

        $proyecto_db->delete();

        return $proyecto_db;
    }

    public static function restore(string $proyecto_id)
    {
        ModelsProyecto::onlyTrashed()->findOrFail($proyecto_id)->restore();

        return response()->json(['success' => true, 'message' => 'Proyecto restablecido'], 200);
    }
}
