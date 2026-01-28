<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Product;
use Error;


final readonly class ViewProduct
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        // TODO implement the resolver
        $product = Product::find($args['id']);
        if (!$product) {
            throw new Error('Producto no encontrado');
        }
        return $product;
    }
}
