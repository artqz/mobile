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
            'bag_size' => $this->items->where('slot', 'bag')->first()->itemable->value,
            'gold' => $this->gold,
            'hp_max' => $this->hp_max,
            'hp_current' => $this->hp_current,
            'location_id' => $this->location_id,
            'in_battle' => $this->in_battle,
            'location' => $this->location,
            'count_wins' => $this->count_wins,
            'count_loses' => $this->count_loses,
            'items' => Item::collection($this->items)
        ];
    }
}
