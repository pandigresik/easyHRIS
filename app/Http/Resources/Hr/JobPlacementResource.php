<?php

namespace App\Http\Resources\Hr;

use Illuminate\Http\Resources\Json\JsonResource;

class JobPlacementResource extends JsonResource
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
            'company_id' => $this->company_id,
            'department_id' => $this->department_id,
            'joblevel_id' => $this->joblevel_id,
            'jobtitle_id' => $this->jobtitle_id,
            'supervisor_id' => $this->supervisor_id,
            'contract_id' => $this->contract_id,
            'active' => $this->active
        ];
    }
}
