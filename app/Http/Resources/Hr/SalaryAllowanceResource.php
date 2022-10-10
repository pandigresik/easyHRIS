<?php

namespace App\Http\Resources\Hr;

use Illuminate\Http\Resources\Json\JsonResource;

class SalaryAllowanceResource extends JsonResource
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
            'component_id' => $this->component_id,
            'year' => $this->year,
            'month' => $this->month,
            'benefit_value' => $this->benefit_value,
            'benefit_key' => $this->benefit_key
        ];
    }
}
