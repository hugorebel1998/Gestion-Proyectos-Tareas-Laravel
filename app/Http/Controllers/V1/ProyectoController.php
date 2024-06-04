<?php

namespace App\Http\Controllers\V1;

use App\Factories\Proyecto;
use App\Http\Controllers\Controller;
use App\Models\Proyecto as ModelsProyecto;
use App\Models\Tarea as ModelsTarea;
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

    public function listarTareas($proyecto_id)
    {
        return Proyecto::select_tareas($proyecto_id);
    }

    public function crearTarea(Request $request, $proyecto_id)
    {
        $usuario_db = $request->get('auth');

        $request->request->add(['proyecto_id' => $proyecto_id]);
        $request->request->add(['usuario_id' => $usuario_db['id']]);

        $tarea = $this->validate($request, [
            'proyecto_id' => 'required|exists:proyectos,id',
            'usuario_id' => 'required|exists:usuarios,id',
            'nombre' => 'required|unique:tareas,nombre',
            'descripcion' => 'required|min:5|max:150',
            'prioridad' => 'required|' . Rule::in(ModelsTarea::PRIOPIDADES_TAREA),
            'estatus' => 'required|' . Rule::in(ModelsTarea::ESTATUS_TAREA),
            'fecha_inicio' => 'required',
            'fecha_termino' => 'required',
        ]);

        return Proyecto::create_task($tarea);
    }

    public function actualizarTarea(Request $request, $proyecto_id, $tarea_id)
    {

        $proyecto_db = ModelsProyecto::findOrFail($proyecto_id);
        $tarea_db = ModelsTarea::where('proyecto_id', $proyecto_db['id'])->findOrFail($tarea_id);

        $tarea = $this->validate($request, [
            'nombre' => 'required|unique:tareas,nombre',
            'descripcion' => 'required|min:5|max:150',
            'prioridad' => 'required|' . Rule::in(ModelsTarea::PRIOPIDADES_TAREA),
            'estatus' => 'required|' . Rule::in(ModelsTarea::ESTATUS_TAREA),
            'fecha_inicio' => 'required',
            'fecha_termino' => 'required',
        ]);

        return Proyecto::update_task($tarea_db, $tarea);
    }

    public function eliminarTarea($proyecto_id, $tarea_id)
    {

        $proyecto_db = ModelsProyecto::findOrFail($proyecto_id);
        $tarea_db = ModelsTarea::where('proyecto_id', $proyecto_db['id'])->findOrFail($tarea_id);

        return Proyecto::delete_task($tarea_db);
    }
}
