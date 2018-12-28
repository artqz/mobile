<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class Chat extends JsonResource
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
            'text' => $this->text,
            'sender' => $this->sender,
            'receiver' => $this->receiver,
            'is_system' => $this->is_system,
            'date' => Carbon::parse($this->created_at)->toW3cString()
        ];
    }
}
