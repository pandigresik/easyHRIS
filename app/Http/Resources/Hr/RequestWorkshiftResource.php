<?php

namespace App\Http\Resources\Hr;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestWorkshiftResource extends JsonResource
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
            'shiftment_id_origin' => $this->shiftment_id_origin,
            'work_date' => $this->work_date,
            'status' => $this->status,
            'description' => $this->description
        ];
    }
}
