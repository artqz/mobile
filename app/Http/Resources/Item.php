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
        if ($this->itemable_type == 'weapon') {
            return [
                'id' => $this->id,
                'name' => $this->itemable->name,
                'name_ru' => $this->itemable->name_ru,
                'itemable_type' => $this->itemable_type,
                'itemable_id' => $this->itemable_id,
                'icon' => $this->itemable->icon,
                'p_atk' => $this->itemable->p_atk,
                'slot' => $this->slot,
                'type' => $this->itemable->type,
                'price' => $this->price
            ];
        }
        elseif ($this->itemable_type == 'armor') {
            return [
                'id' => $this->id,
                'name' => $this->itemable->name,
                'name_ru' => $this->itemable->name_ru,
                'itemable_type' => $this->itemable_type,
                'itemable_id' => $this->itemable_id,
                'icon' => $this->itemable->icon,
                'p_def' => $this->itemable->p_def,
                'slot' => $this->slot,
                'type' => $this->itemable->type,
                'price' => $this->price
            ];
        }
        elseif ($this->itemable_type == 'jewellery') {
            return [
                'id' => $this->id,
                'name' => $this->itemable->name,
                'name_ru' => $this->itemable->name_ru,
                'itemable_type' => $this->itemable_type,
                'itemable_id' => $this->itemable_id,
                'icon' => $this->itemable->icon,
                'm_def' => $this->itemable->p_def,
                'slot' => $this->slot,
                'type' => $this->itemable->type,
                'price' => $this->price
            ];
        }
        elseif ($this->itemable_type == 'etc') {
            return [
                'id' => $this->itemable->id,
                'name' => $this->itemable->name,
                'name_ru' => $this->itemable->name_ru,
                'itemable_type' => $this->itemable_type,
                'itemable_id' => $this->itemable_id,
                'icon' => $this->itemable->icon,
                'count' => $this->count,
                'price' => $this->price
            ];
        }

    }
}
