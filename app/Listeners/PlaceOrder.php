<?php

namespace App\Listeners;

use App\Events\OrderSucceeded;

class PlaceOrder
{


    /**
     * Handle the event.
     */
    public function handle(OrderSucceeded $event)
    {
        $order = $event->order;
        $order->status = 'Paid';
        $order->save();
        \Log::info("Order {$order->id} placed");
    }
}
