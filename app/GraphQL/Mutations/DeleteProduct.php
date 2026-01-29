<?php

namespace App\GraphQL\Mutations;

use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DeleteProduct
{
    use AuthorizesRequests;

    public function __invoke($_, array $args)
    {
        $product = Product::findOrFail($args['id']);

        // Usa ProductPolicy::delete()
        $this->authorize('delete', $product);

        $product->delete();

        return $product;
    }
}
