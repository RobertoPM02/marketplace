<?php

namespace App\GraphQL\Queries;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class MyCart
{
    public function __invoke($_, array $args)
{
    $user = auth()->user();

    return Cart::firstOrCreate(
        [
            'user_id' => $user->id,
            'status' => 'active',
        ],
        [
            'subtotal' => 0,
            'taxes' => 0,
            'shipping' => 0,
            'total' => 0,
        ]
    )->load('items.product');
}

}
