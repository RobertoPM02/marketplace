<?php

namespace App\GraphQL\Mutations;

use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class UpdateCartItem
{
    public function __invoke($_, array $args)
    {
        $user = Auth::user();

        $cartItem = CartItem::where('id', $args['cart_item_id'])
            ->whereHas('cart', fn ($q) =>
                $q->where('user_id', $user->id)
            )
            ->with('product')
            ->firstOrFail();

        $quantity = $args['quantity'];

        // Si cantidad <= 0 → eliminar item
        if ($quantity <= 0) {
            $cartItem->delete();
            return $cartItem->cart->fresh()->load('items.product');
        }

        // Límite máximo por producto
        if ($quantity > 10) {
            throw new \Exception('Máximo 10 unidades por producto');
        }

        // Validar stock
        if ($quantity > $cartItem->product->stock) {
            throw new \Exception('Stock insuficiente');
        }

        // Actualizar cantidad
        $cartItem->update([
            'quantity' => $quantity
        ]);

        return $cartItem->cart->fresh()->load('items.product');
    }
}

