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
            'leave_date' => $this->leave_date,
            'amount' => $this->amount,
            'description' => $this->description
        ];
    }
}
