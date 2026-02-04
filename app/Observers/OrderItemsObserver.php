<?php

namespace App\Observers;

use App\Models\OrderItems;
use App\Models\Product;
use App\Notifications\SaleAlert;
use Illuminate\Support\Facades\Auth;

class OrderItemsObserver
{
    /**
     * Handle the OrderItems "created" event.
     */
    public function created(OrderItems $orderItem): void
    {

        $product = Product::find($orderItem->product_id);

        if ($product) {

            $seller = $product->user;


            $buyer = Auth::user();


            if ($seller && $buyer && $seller->id !== $buyer->id) {


                $seller->notify(new SaleAlert(
                    $product,
                    $orderItem->quantity,
                    $buyer->name
                ));
            }
        }
    }
}