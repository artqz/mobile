<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Item extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
          'id' => $this->itemable->id,
          'name' => $this->itemable->name,
          'name_ru' => $this->itemable->name_ru,
          'itemable_type' => $this->itemable_type,
          'itemable_id' => $this->itemable_id,
          'icon' => $this->itemable->icon,
          'p_atk' => $this->itemable->p_atk,
          'price' => $this->price
        ];
    }
}
