<?php

namespace App\Http\Services;

use App\Http\Requests\UpdateOrderRequest;
use App\Order;


class OrderService
{
    public function put(UpdateOrderRequest $request, $order_id)
    {
        $partner = Order::with("partner")->where("id", $order_id)->first()->partner;
        $order = Order::where("id", $order_id)->first();

        $order->status = $request->status;
        $partner->email = $request->email;
        $partner->name = $request->partner;

        $order->save();
        $partner->save();

        return [ 'status' => true ];
    }
}