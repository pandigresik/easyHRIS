<?php

namespace App\Http\Resources\Hr;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceLogfingerResource extends JsonResource
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
            'type_absen' => $this->type_absen,
            'fingertime' => $this->fingertime,
            'fingerprint_device_id' => $this->fingerprint_device_id
        ];
    }
}
