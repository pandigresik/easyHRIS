<?php

namespace App\Http\Resources\Hr;

use Illuminate\Http\Resources\Json\JsonResource;

class ShiftmentGroupDetailResource extends JsonResource
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
            'shiftment_group_id' => $this->shiftment_group_id,
            'shiftment_id' => $this->shiftment_id,
            'sequence' => $this->sequence
        ];
    }
}
