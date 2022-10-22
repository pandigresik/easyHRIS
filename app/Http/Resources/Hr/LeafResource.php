<?php

namespace App\Http\Resources\Hr;

use Illuminate\Http\Resources\Json\JsonResource;

class LeafResource extends JsonResource
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
            'reason_id' => $this->reason_id,
            'leave_start' => $this->leave_start,
            'leave_end' => $this->leave_end,
            'amount' => $this->amount,
            'status' => $this->status,
            'step_approval' => $this->step_approval,
            'amount_approval' => $this->amount_approval,
            'description' => $this->description
        ];
    }
}
