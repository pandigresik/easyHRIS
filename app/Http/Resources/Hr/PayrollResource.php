<?php

namespace App\Http\Resources\Hr;

use Illuminate\Http\Resources\Json\JsonResource;

class PayrollResource extends JsonResource
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
            'payroll_period_id' => $this->payroll_period_id,
            'take_home_pay' => $this->take_home_pay,
            'take_home_pay_key' => $this->take_home_pay_key
        ];
    }
}
