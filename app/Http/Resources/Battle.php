<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class Battle extends JsonResource
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
          'user1' => User::make($this->user1),
          'user2' => User::make($this->user2),
          'npc' => $this->npc,
          'type' => $this->type,
          'rounds' => $this->rounds,
          'date' => Carbon::parse($this->started_at)->toW3cString()
      ];
    }
}
