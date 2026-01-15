<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Product;


final readonly class ViewProduct
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        // TODO implement the resolver

        
        return Product::find($args['id']);

    }
}
