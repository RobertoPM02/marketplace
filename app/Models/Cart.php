<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'status'];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // --- CÁLCULOS ---

    public function getSubtotalAttribute()
    {
        return $this->items->sum(fn ($item) =>
            $item->product->price * $item->quantity
        );
    }

    public function getShippingAttribute()
    {
        return $this->subtotal > 0 ? 60 : 0;
    }

    public function getTaxesAttribute()
    {
        return $this->subtotal * 0.16;
    }

    public function getTotalAttribute()
    {
        return $this->subtotal + $this->shipping + $this->taxes;
    }
}

