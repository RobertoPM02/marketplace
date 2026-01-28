<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\Auth;

class UpdateProfile
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();


        if (isset($args['email'])) {
            throw new \Exception("No está permitido cambiar el correo electrónico.");
        }


        $user->update([
            'name' => $args['name'] ?? $user->name,
            'phone_number' => $args['phone_number'] ?? $user->phone_number,
        ]);

        return [
            'status' => 'SUCCESS',
            'message' => '¡Tus datos se han actualizado correctamente!',
            'user' => $user
        ];
    }
}