<?php

namespace App\Http\Resources\Hr;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceSummaryResource extends JsonResource
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
            'year' => $this->year,
            'month' => $this->month,
            'total_workday' => $this->total_workday,
            'total_in' => $this->total_in,
            'total_loyality' => $this->total_loyality,
            'total_absent' => $this->total_absent,
            'total_overtime' => $this->total_overtime
        ];
    }
}
