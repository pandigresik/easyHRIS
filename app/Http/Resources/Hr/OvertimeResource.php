<?php

namespace App\Http\Resources\Hr;

use Illuminate\Http\Resources\Json\JsonResource;

class OvertimeResource extends JsonResource
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
            'employee_id' => $this->employee_id,
            'shiftment_id' => $this->shiftment_id,
            'approved_by_id' => $this->approved_by_id,
            'overtime_date' => $this->overtime_date,
            'start_hour' => $this->start_hour,
            'end_hour' => $this->end_hour,
            'raw_value' => $this->raw_value,
            'calculated_value' => $this->calculated_value,
            'holiday' => $this->holiday,
            'overday' => $this->overday,
            'description' => $this->description
        ];
    }
}
