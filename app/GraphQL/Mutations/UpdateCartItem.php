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
            ->firstOrFail();

        if ($args['quantity'] <= 0) {
            $cartItem->delete();
        } else {
            $cartItem->update([
                'quantity' => $args['quantity']
            ]);
        }

        return $cartItem->cart->fresh();
    }
}
