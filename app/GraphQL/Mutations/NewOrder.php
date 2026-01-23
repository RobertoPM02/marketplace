<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItems;
use App\Models\CartItem;
use App\Models\Cart;
use Error;

final readonly class NewOrder
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        // TODO implement the resolver
        return DB::transaction(function () use ($args) {
            $user = auth()->user();
            $order = Order::create([
                'user_id' => $user->id,
                'address' => $args['address'],
                'status' => 'pending',
                'payment_method' => $args['payment_method'],
                'sub_total' => 0,
                'tax' => 0,
                'shipping' => 0,
                'total' => 0,
            ]);

            $subtotal = 0;

            foreach ($args['items'] as $itemInput){

                $product = Product::find($itemInput['product_id']);

                if (!$product){
                    throw new Error('Producto no encontrado');
                }

                if ($product->stock < $itemInput['quantity']) {
                    throw new Error("No hay suficiente unidades para {$product->name}");
                }

                OrderItems::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_image' => $product->image,
                    'quantity' => $itemInput['quantity'],
                    'price' => $product->price,
                ]);

                $subtotal += $product->price * $itemInput['quantity'];
                $product->decrement('stock', $itemInput['quantity']);
                
            }

            $tax = $subtotal * 0.16;
            $shipping = $subtotal > 0 ? 60 : 0;
            $total = $subtotal + $tax + $shipping;

            $order->update([
                'sub_total' => $subtotal,
                'tax' => $tax,
                'shipping' => $shipping,
                'total' => $total,
            ]);

            $cart = Cart::where('user_id', $user->id)->first();

            if ($cart) {
                CartItem::where('cart_id', $cart->id)->delete();
            }

            return $order;
        });
        
    }
}
