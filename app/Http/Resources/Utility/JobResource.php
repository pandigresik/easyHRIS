<?php

namespace App\Http\Resources\Utility;

use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
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
            'queue' => $this->queue,
            'payload' => $this->payload,
            'attempts' => $this->attempts,
            'reserved_at' => $this->reserved_at,
            'available_at' => $this->available_at
        ];
    }
}
