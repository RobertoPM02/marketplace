<?php

namespace App\GraphQL\Mutations;

use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class RemoveFromCart
{
    public function __invoke($_, array $args)
    {
        $user = Auth::user();

        $cartItem = CartItem::where('id', $args['cart_item_id'])
            ->whereHas('cart', fn ($q) =>
                $q->where('user_id', $user->id)
            )
            ->firstOrFail();

        $cart = $cartItem->cart;

        $cartItem->delete();

        return $cart->fresh();
    }
}

