<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Product;

class SaleAlert extends Notification
{
    use Queueable;

    protected $product;
    protected $quantity;
    protected $buyerName;

    public function __construct(Product $product, $quantity, $buyerName)
    {
        $this->product = $product;
        $this->quantity = $quantity;
        $this->buyerName = $buyerName;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => '¡Nueva Venta Realizada!',
            'message' => "El usuario {$this->buyerName} ha comprado {$this->quantity} unidad(es) de tu producto '{$this->product->name}'.",
            'product_id' => $this->product->id,
            'image_url' => $this->product->image_url,
            'total_earned' => $this->product->price * $this->quantity,
            'date' => now()->toDateTimeString(),
        ];
    }
}