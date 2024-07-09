<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'stockStatus' => $this->stock_status ? true : false,
            'deletedStatus' => !empty($this->deleted_at) ? 'Ürün Silinmiştir.' : '',
            'deletedAt' => $this->deleted_at
        ];
    }
}
