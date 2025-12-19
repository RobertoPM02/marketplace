<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;

class Login
{
    public function __invoke($_, array $args)
    {
        $login = $args['login'];
        $password = $args['password'];

        $user = filter_var($login, FILTER_VALIDATE_EMAIL)
            ? User::where('email', $login)->first()
            : User::where('name', $login)->first();

        

        if (! $user) {
            throw new AuthenticationException('Usuario no encontrado');
        }
        if (! Hash::check($password, $user->password)) {
            throw new AuthenticationException('Contraseña incorrecta');
        }

        return [
            'access_token' => $user->createToken('auth_token')->plainTextToken,
            'token_type' => 'Bearer',
            'user' => $user,
        ];
    }
}

