<?php

namespace App\Http\Controllers\V1;

use App\Factories\Proyecto;
use App\Http\Controllers\Controller;
use App\Models\Proyecto as ModelsProyecto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProyectoController extends Controller
{

    public function listar($proyecto_id = null)
    {
        return Proyecto::select($proyecto_id);
    }

    public function crear(Request $request)
    {
        $usuario_db = $request->get('auth');

        $request->request->add(['usuario_id' => $usuario_db['id']]);

        $proyecto = $this->validate($request, [
            'usuario_id'    => 'required|exists:usuarios,id',
            'nombre'        => 'required|min:2|max:60|unique:proyectos,nombre',
            'descripcion'   => 'required',
            'estatus'       => 'required|' . Rule::in(ModelsProyecto::ESTATUS),
            'fecha_inicio'  => 'sometimes',
            'fecha_termino' => 'sometimes',
        ]);

        return Proyecto::create($proyecto);
    }

    public function actualizar(Request $request, $proyecto_id)
    {
        $proyecto_db = ModelsProyecto::findOrFail($proyecto_id);

        $proyecto = $this->validate($request, [
            'nombre'        => 'sometimes|min:2|max:60|unique:proyectos,nombre,' . $proyecto_db->id,
            'descripcion'   => 'sometimes',
            'estatus'       => 'sometimes|' . Rule::in(ModelsProyecto::ESTATUS),
            'fecha_inicio'  => 'sometimes',
            'fecha_termino' => 'sometimes',
        ]);

        return Proyecto::update($proyecto_db, $proyecto);
    }

    public function eliminar($proyecto_id)
    {
        return Proyecto::delete($proyecto_id);
    }

    public function restablecer($proyecto_id)
    {
        return Proyecto::restore($proyecto_id);
    }
}
