<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;
use Exception;

class MarkAsRead
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {

        $notification = DatabaseNotification::find($args['id']);


        if (!$notification) {
            throw new Exception("La notificación no existe.");
        }


        if ($notification->notifiable_id != Auth::id()) {
            throw new Exception("No tienes permiso para editar esta notificación.");
        }


        $notification->markAsRead();


        return true;
    }
}