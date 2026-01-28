<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\User;

final readonly class CreateUser
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        // TODO implement the resolver
        $user = User::create($args);

        $user->role_id = 2;
        $user->save();

        return $user;
    }
}
