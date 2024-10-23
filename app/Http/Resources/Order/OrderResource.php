<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data =  [
            "id" => $this->id ,
            "total" => $this->total,
            "status" => $this->status,
            "date" => $this->created_at->format('d M,Y H:i'),
            "items" => $this->products
        ];

        return $data;
    }
}
