<?php

namespace App\Factories;

use App\Exceptions\BadRequestException;
use App\Models\Usuario as ModelsUsuario;
use Firebase\JWT\JWT;
use Carbon\Carbon;

class Auth
{
    public static function login(array $usuario)
    {
        $usuario_db = ModelsUsuario::where('email', $usuario['email'])->first();

        if (!$usuario_db)
            throw new BadRequestException('Usuario o contraseña invalido.', 401);

        if ($usuario_db['estatus'] != ModelsUsuario::ESTATUS_ACTIVO)
            throw new BadRequestException('Usuario no activo', 404);

        if (!password_verify($usuario['password'], $usuario_db['password']))
            throw new BadRequestException('La contraseña no coincide.', 401);


        $token_fecha_creacion = Carbon::now()->timestamp;
        $toke_life = time() + intval(env('TOKEN_LIFE'));
        $token_secret = env('TOKEN_SECRET');
        $token_algoritmo = env('TOKEN_ALGORITMO');


        $payload = [
            'exp' => $toke_life,
            'iat' => $token_fecha_creacion,
            'data' => [
                'id'          => $usuario_db['id'],
                'username'    => $usuario_db['username'],
                'nombre_completo' => $usuario_db['nombre_completo'],
                'email'       => $usuario_db['email'],
                'estatus'     => $usuario_db['estatus'],
            ]
        ];

        $token = JWT::encode($payload, $token_secret, $token_algoritmo);

        if (!$token)
            throw new BadRequestException('No es posible iniciar sesión, comunicate con tu administrador.', 500);


        return [
            'success' => true,
            'access_token' => $token,
            'type' => 'bearer',
            'exp' => $toke_life,
            'user' => [
                'id'          => $usuario_db['id'],
                'username'    => $usuario_db['username'],
                'nombre_completo' => $usuario_db['nombre_completo'],
                'email'       => $usuario_db['email'],
                'estatus'     => $usuario_db['estatus'],
            ],
        ];
    }
}
