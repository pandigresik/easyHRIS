<?php

namespace App\Http\Resources\Hr;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'contract_id' => $this->contract_id,
            'company_id' => $this->company_id,
            'department_id' => $this->department_id,
            'joblevel_id' => $this->joblevel_id,
            'jobtitle_id' => $this->jobtitle_id,
            'supervisor_id' => $this->supervisor_id,
            'region_of_birth_id' => $this->region_of_birth_id,
            'city_of_birth_id' => $this->city_of_birth_id,
            'address' => $this->address,
            'join_date' => $this->join_date,
            'employee_status' => $this->employee_status,
            'code' => $this->code,
            'full_name' => $this->full_name,
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth,
            'identity_number' => $this->identity_number,
            'identity_type' => $this->identity_type,
            'marital_status' => $this->marital_status,
            'email' => $this->email,
            'leave_balance' => $this->leave_balance,
            'tax_group' => $this->tax_group,
            'resign_date' => $this->resign_date,
            'have_overtime_benefit' => $this->have_overtime_benefit,
            'risk_ratio' => $this->risk_ratio,
            'profile_image' => $this->profile_image,
            'profile_size' => $this->profile_size,
            'salary_group_id' => $this->salary_group_id,
            'shiftment_group_id' => $this->shiftment_group_id
        ];
    }
}
