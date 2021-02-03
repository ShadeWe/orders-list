<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateOrderRequest;
use App\Http\Services\OrderService;
use App\Order;


class OrderController extends Controller
{
    /**
     * Получение списка заказов
     *
     * @return void
     */
    public function show()
    {
        return Order::with(['partner', 'order_products.product'])->get();
    }

    /**
     * Получение заказа для редактирования
     *
     * @param [type] $order_id
     * @return void
     */
    public function edit($order_id)
    {
        return Order::with(['partner', 'order_products.product'])->where("id", $order_id)->first();
    }

    /**
     * Обновление заказа с валидацией данных
     *
     * @param OrderService $service
     * @param UpdateOrderRequest $request
     * @param [type] $order_id
     * @return void
     */
    public function update(OrderService $service, UpdateOrderRequest $request, $order_id)
    {
        return $service->put($request, $order_id);
    }
}
