<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\Auth;

class Logout
{
    public function __invoke($_, array $args): bool
    {
        /** @var \App\Models\User&\Laravel\Sanctum\HasApiTokens $user */
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return false;
        }

        // Revoca SOLO el token actual
        $user->currentAccessToken()->delete();

        return true;
    }
}
