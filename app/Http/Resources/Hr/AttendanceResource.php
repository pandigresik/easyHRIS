<?php

namespace App\Http\Resources\Hr;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
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
            'reason_id' => $this->reason_id,
            'attendance_date' => $this->attendance_date,
            'description' => $this->description,
            'check_in' => $this->check_in,
            'check_out' => $this->check_out,
            'early_in' => $this->early_in,
            'early_out' => $this->early_out,
            'late_in' => $this->late_in,
            'late_out' => $this->late_out,
            'absent' => $this->absent
        ];
    }
}
