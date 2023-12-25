<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
        'child_type' => $this->child_type,
        'parent' => $this->parent==null?null:$this->parent->name,
      ];
    }
}
