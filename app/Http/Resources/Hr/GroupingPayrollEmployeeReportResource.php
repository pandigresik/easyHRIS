<?php

namespace App\Http\Resources\Hr;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupingPayrollEmployeeReportResource extends JsonResource
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
            'grouping_payroll_entity_id' => $this->grouping_payroll_entity_id
        ];
    }
}
