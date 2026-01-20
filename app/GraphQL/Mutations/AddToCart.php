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

        // Obtener o crear carrito activo
        $cart = Cart::firstOrCreate([
            'user_id' => $user->id,
            'status' => 'active',
        ]);

        // Validar producto
        $product = Product::findOrFail($args['product_id']);

        // Validar stock disponible
        if ($product->stock <= 0) {
            throw new \Exception('Producto sin stock');
        }

        // Buscar item existente
        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        $requestedQty = $args['quantity'];
        $currentQty = $item?->quantity ?? 0;
        $newQty = $currentQty + $requestedQty;

        // Límite máximo por producto
        if ($newQty > 10) {
            throw new \Exception('Máximo 10 unidades por producto');
        }

        // Validar contra stock real
        if ($newQty > $product->stock) {
            throw new \Exception('Stock insuficiente');
        }

        // Crear o actualizar item
        if ($item) {
            $item->update([
                'quantity' => $newQty,
            ]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $requestedQty,
            ]);
        }

        return $cart->fresh()->load('items.product');
    }
}

