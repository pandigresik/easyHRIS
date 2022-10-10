<?php

namespace App\Http\Resources\Hr;

use Illuminate\Http\Resources\Json\JsonResource;

class SalaryGroupDetailResource extends JsonResource
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
            'component_id' => $this->component_id,
            'salary_group_id' => $this->salary_group_id,
            'component_value' => $this->component_value
        ];
    }
}
