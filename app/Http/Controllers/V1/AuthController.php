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
}
