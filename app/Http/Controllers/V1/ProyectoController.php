<?php

namespace App\Http\Controllers\V1;

use App\Factories\Proyecto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{

    public function listar($proyecto_id = null)
    {
        return Proyecto::select($proyecto_id);
    }

    public function crear(Request $request)
    {
        $proyecto = $this->validate($request, [
            'nombre'        => 'required|min:2|max:60',
            'descripcion'   => 'required',
            'estatus'       => 'required',
            'fecha_inicio'  => 'required',
            'fecha_termino' => 'required',
        ]);

        return Proyecto::create($proyecto);
    }
}
