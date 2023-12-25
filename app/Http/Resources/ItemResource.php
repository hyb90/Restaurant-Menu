<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      return [
        'id' => $this->id,
        'name' => $this->name,
        'code' => $this->code,
        'discount' => $this->discount,
        'price' => $this->price,
        'discount_price' => $this->discount_price,
        'category' => $this->category==null?null:$this->category->name,

      ];
    }
}
