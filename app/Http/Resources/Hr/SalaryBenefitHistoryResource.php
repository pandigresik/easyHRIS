<?php

namespace App\Http\Resources\Hr;

use Illuminate\Http\Resources\Json\JsonResource;

class SalaryBenefitHistoryResource extends JsonResource
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
            'contract_id' => $this->contract_id,
            'new_benefit_value' => $this->new_benefit_value,
            'old_benefit_value' => $this->old_benefit_value,
            'benefit_key' => $this->benefit_key,
            'description' => $this->description
        ];
    }
}
