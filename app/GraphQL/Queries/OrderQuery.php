<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Order;
use Error;
use Illuminate\Support\Facades\Auth;

final readonly class OrderQuery
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        // TODO implement the resolver
        $user = Auth::user();

        $order = $user->orders()->where('id', $args['id'])->first();
        if (!$order) {
            throw new Error('Pedido no encontrado');
        }
        return $order;
    }
}
