<?php

namespace App\GraphQL\Queries;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class MyProducts
{
    public function __invoke($_, array $args)
    {
        return Product::where('user_id', Auth::id())->get();
    }
}
