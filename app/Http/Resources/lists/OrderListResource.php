<?php

namespace App\Http\Resources\lists;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'order' => [
                'id' => $this->id,
                'status' => $this->status,
                'orderNo' => $this->order_no,
                'orderDate' => $this->order_date,
                'shipmentAddress' => $this->shipment_address
            ],
            'customer' => [
                'id' => $this->customer->id,
                'idNumber' => $this->customer->id_number,
                'name' => $this->customer->name,
                'surname' => $this->customer->surname,
            ],
            'products' => $this->products->map(function ($product) {
                return [
                    'productId' => $product->product->id,
                    'productName' => $product->product->name,
                    'stockStatus' => $product->product->stock_status,
                ];
            }),
        ];
    }
}
