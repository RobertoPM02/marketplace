<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use Illuminate\Support\Facades\Auth;

final readonly class MyOrders
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        // TODO implement the resolver
        return Auth::user()->orders()->orderBy('created_at', 'desc')->get();
    }
}
