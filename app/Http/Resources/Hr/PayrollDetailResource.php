<?php

namespace App\Http\Resources\Hr;

use Illuminate\Http\Resources\Json\JsonResource;

class PayrollDetailResource extends JsonResource
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
            'payroll_id' => $this->payroll_id,
            'component_id' => $this->component_id,
            'benefit_value' => $this->benefit_value,
            'benefit_key' => $this->benefit_key
        ];
    }
}
