<?php

namespace App\Factories;

use App\Models\Tarea as ModelsTarea;

class Tarea
{

    public static function select(string|null $tarea_id)
    {
        if (empty($tarea_id))
            return ModelsTarea::all();

        return ModelsTarea::findOrFail($tarea_id);
    }

    public static function create(array $tarea)
    {
        return  ModelsTarea::create($tarea);
    }

    public static function update(object $tarea_db, array $tarea)
    {
        $tarea_db->fill($tarea);

        $tarea_db->save();

        return $tarea_db;
    }

    public static function delete(string $tarea_id)
    {
        $tarea_db = ModelsTarea::findOrFail($tarea_id);

        $tarea_db->delete();

        return $tarea_db;
    }
}
