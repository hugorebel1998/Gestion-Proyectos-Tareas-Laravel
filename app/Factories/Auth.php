<?php

namespace App\Factories;

use App\Exceptions\BadRequestException;
use App\Models\Usuario as ModelsUsuario;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

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

    public static function validateBearerToken($token)
    {
        try {
            $token_secret = env('TOKEN_SECRET');
            $token_algoritmo = env('TOKEN_ALGORITMO');

            $data = JWT::decode($token, new Key($token_secret, $token_algoritmo));

            $payload = [
                'success' => true,
                'user' => [
                    'id' => data_get($data, 'data.id'),
                    'username'   => data_get($data, 'data.username'),
                    'nombre_completo' => data_get($data, 'data.nombre_completo'),
                    'email'      => data_get($data, 'data.email'),
                    'estatus'    => data_get($data, 'data.estatus'),
                ],
            ];

            return $payload;
        } catch (Exception $e) {
            Log::error($e);
            throw new BadRequestException('El token expiró porfavor de generar uno nuevo.', 401);
        }
    }

    public static function refreshToken($data)
    {

        $usuario_db = ModelsUsuario::where('id', $data['usuario_id'])->first();

        if (!$usuario_db)
            throw new BadRequestException('Usuario no encontrado', 404);


        try {
            $token_fecha_creacion = Carbon::now()->timestamp;
            $toke_life = time() + intval(env('TOKEN_LIFE'));
            $token_secret = env('TOKEN_SECRET');
            $token_algoritmo = env('TOKEN_ALGORITMO');


            $payload = [
                'exp' => $toke_life,
                'iat' => $token_fecha_creacion,
                'data' => [
                    'id' => $usuario_db['id'],
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
                ]

            ];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new BadRequestException('Error al generar token.', 401);
        }
    }
}
