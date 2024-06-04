<?php

namespace App\Http\Controllers\V1;

use App\Factories\Tarea\Comentario;
use App\Http\Controllers\Controller;
use App\Models\Tarea as ModelsTarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public function crearComentario(Request $request, $tarea_id)
    {
        $usuario_db = $request->get('auth');
        $tarea_db = ModelsTarea::findOrFail($tarea_id);

        $request->request->add(['usuario_id' => $usuario_db['id']]);
        $request->request->add(['tarea_id' => $tarea_db['id']]);

        $comentario = $this->validate($request, [
            'tarea_id'    => 'required|exists:tareas,id',
            'usuario_id'    => 'required|exists:usuarios,id',
            'comentario'    => 'required'
        ]);

        return Comentario::create($comentario);
    }

    
}
