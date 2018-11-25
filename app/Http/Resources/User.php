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
            'slot_weapon' => $this->slot_weapon,
            'slot_sub_weapon' => $this->slot_sub_weapon,
            'slot_helmet' => $this->slot_helme,
            'slot_armor' => $this->slot_armor,
            'slot_belt' => $this->slot_belt,
            'slot_pants' => $this->lot_pants,
            'slot_gloves' => $this->slot_gloves,
            'slot_shoes' => $this->slot_shoes,
            'slot_earring_one' => $this->slot_earring_one,
            'slot_earring_two' => $this->slot_earring_two,
            'slot_ring_one' => $this->slot_ring_one,
            'slot_ring_two' => $this->slot_ring_two,
            'slot_necklace' => $this->slot_necklace,
            'slot_bag' => $this->slot_bag,
            'location_id' => $this->location_id,
        ];
    }
}
