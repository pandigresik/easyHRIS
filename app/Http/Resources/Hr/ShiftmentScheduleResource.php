<?php

namespace App\Http\Resources\Hr;

use Illuminate\Http\Resources\Json\JsonResource;

class ShiftmentScheduleResource extends JsonResource
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
            'shiftment_id' => $this->shiftment_id,
            'work_day' => $this->work_day,
            'start_hour' => $this->start_hour,
            'end_hour' => $this->end_hour
        ];
    }
}
