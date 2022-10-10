<?php

namespace App\Http\Resources\Base;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'parent_id' => $this->parent_id,
            'address' => $this->address,
            'code' => $this->code,
            'name' => $this->name,
            'birth_day' => $this->birth_day,
            'email' => $this->email,
            'tax_number' => $this->tax_number
        ];
    }
}
