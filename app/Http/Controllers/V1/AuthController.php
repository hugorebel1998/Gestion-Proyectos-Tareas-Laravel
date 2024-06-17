<?php

namespace App\Http\Controllers\V1;

use App\Factories\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function inicio(Request $request)
    {
        $usuario = $this->validate($request, [
            'email'    => 'required',
            'password' => 'required',
        ]);

        return Auth::login($usuario);
    }

    public function refrescarToken(Request $request)
    {
        $token = $this->validate($request, [
            'token' => 'required',
            'usuario_id' => 'required',
        ]);

        return Auth::refreshToken($token);
    }
}
