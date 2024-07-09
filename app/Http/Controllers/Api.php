<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderListRequest;
use App\Http\Resources\lists\OrderListResource;
use App\Models\Orders;

class Api
{

    public function orders(OrderListRequest $request)
    {
        try {

            $query = Orders::with([
                'products',
                'customer',
                'status',
            ])
                ->where('customer_id', $request->get('customer_id'))
                ->orderBy('id', 'DESC');

            if ($request->has('order_no')) {
                $query->where('order_no', $request->input('order_no'));
            }

            $orders = $query->get();
            $data = OrderListResource::collection($orders);

            return response()->json([
                'orders' => $data->resolve(),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Internal Server Error',
                'message' => 'Hata'
            ], 500);
        }
    }
}
