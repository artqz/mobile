<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'avatar' => $this->avatar,
            'level' => $this->level,
            'inventory_size' => $this->inventory_size,
            'gold' => $this->gold,
            'location_id' => $this->location_id,
            'items' => Item::collection($this->items)
        ];
    }
}
