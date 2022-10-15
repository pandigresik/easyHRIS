<?php

namespace App\Http\Resources\Hr;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkshiftGroupResource extends JsonResource
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
            'work_date' => $this->work_date
        ];
    }
}
