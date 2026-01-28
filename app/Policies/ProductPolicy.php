<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Determina si el usuario puede eliminar el producto
     */
    public function delete(User $user, Product $product): bool
    {
        // Admin puede borrar cualquier producto
        if ($user->role && $user->role->name === 'admin') {
            return true;
        }

        // Usuario normal solo puede borrar SUS productos
        return $user->id === $product->user_id;
    }
}
