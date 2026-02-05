<?php

namespace App\Observers;

use App\Models\OrderItems;
use App\Models\Product;
use App\Notifications\SaleAlert;
use App\Notifications\PurchaseSuccess;
use Illuminate\Support\Facades\Auth;

class OrderItemsObserver
{
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


            if ($buyer) {
                $buyer->notify(new PurchaseSuccess(
                    $product,
                    $orderItem->quantity
                ));
            }
        }
    }
}