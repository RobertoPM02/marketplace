<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Order;

final readonly class AllOrders
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        // TODO implement the resolver
        $user = auth()->user();
        $orders = Order::where('user_id', $user->id)->get();
        return $orders;
    }
}
