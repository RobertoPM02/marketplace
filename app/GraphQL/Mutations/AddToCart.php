<?php

namespace App\GraphQL\Mutations;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class AddToCart
{
    public function __invoke($_, array $args)
    {
        $user = Auth::user();

        // obtener o crear carrito activo
        $cart = Cart::firstOrCreate([
            'user_id' => $user->id,
            'status' => 'active',
        ]);

        //  Validar producto
        $product = Product::findOrFail($args['product_id']);

        //  Crear o actualizar item
        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            $item->increment('quantity', $args['quantity']);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $args['quantity'],
            ]);
        }

        return $cart->load('items.product');
    }
}
