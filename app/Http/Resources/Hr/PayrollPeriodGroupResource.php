<?php

namespace App\Http\Resources\Hr;

use Illuminate\Http\Resources\Json\JsonResource;

class PayrollPeriodGroupResource extends JsonResource
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
            'name' => $this->name,
            'type_period' => $this->type_period,
            'description' => $this->description
        ];
    }
}
