<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'         => (int)$this->id,
            'name'       => $this->name,
            'quantity'   => (int)$this->quantity,
            'price'      => (float)$this->price,
            'tax'        => (integer)$this->tax,
            'created_at' => $this->created_at->format('F j, Y'),
        ];
    }
}
