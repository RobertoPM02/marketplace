<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Order;
use Error;

final readonly class OrderQuery
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        // TODO implement the resolver

        $order = Order::find($args['id']);
        if (!$order) {
            throw new Error('Pedido no encontrado');
        }
        return $order;
    }
}
