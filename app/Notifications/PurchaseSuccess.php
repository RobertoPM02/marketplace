<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Product;

class PurchaseSuccess extends Notification
{
    use Queueable;

    protected $product;
    protected $quantity;

    public function __construct(Product $product, $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => '¡Compra Exitosa!',
            'message' => "Has comprado exitosamente {$this->quantity} unidad(es) de '{$this->product->name}'.",
            'product_id' => $this->product->id,
            'image_url' => $this->product->image_url ?? $this->product->image ?? null,
            'total_earned' => -($this->product->price * $this->quantity),
            'date' => now()->toDateTimeString(),
        ];
    }
}