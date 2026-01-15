<?php

namespace App\GraphQL\Mutations;

use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

final class AddToCart
{
    public function __invoke($_, array $args)
    {
        
        $userId = Auth::id() ?? 1; 

        $cartItem = CartItem::where('user_id', $userId)
            ->where('product_id', $args['product_id'])
            ->first();

        if ($cartItem) {
            // Si ya existe, actualizamos la cantidad
            $cartItem->quantity += $args['quantity'];
            $cartItem->save();
        } else {
            // Si no existe, lo creamos
            $cartItem = CartItem::create([
                'user_id' => $userId,
                'product_id' => $args['product_id'],
                'quantity' => $args['quantity']
            ]);
        }

        return $cartItem;
    }
}