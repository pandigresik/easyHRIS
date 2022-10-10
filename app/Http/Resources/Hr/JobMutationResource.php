<?php

namespace App\Http\Resources\Hr;

use Illuminate\Http\Resources\Json\JsonResource;

class JobMutationResource extends JsonResource
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
            'old_company_id' => $this->old_company_id,
            'old_department_id' => $this->old_department_id,
            'old_joblevel_id' => $this->old_joblevel_id,
            'old_jobtitle_id' => $this->old_jobtitle_id,
            'old_supervisor_id' => $this->old_supervisor_id,
            'new_company_id' => $this->new_company_id,
            'new_department_id' => $this->new_department_id,
            'new_joblevel_id' => $this->new_joblevel_id,
            'new_jobtitle_id' => $this->new_jobtitle_id,
            'new_supervisor_id' => $this->new_supervisor_id,
            'contract_id' => $this->contract_id,
            'type' => $this->type
        ];
    }
}
