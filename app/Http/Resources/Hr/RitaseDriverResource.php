<?php

namespace App\Http\Resources\Hr;

use Illuminate\Http\Resources\Json\JsonResource;

class RitaseDriverResource extends JsonResource
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
            'work_date' => $this->work_date,
            'km' => $this->km,
            'double_rit' => $this->double_rit
        ];
    }
}
