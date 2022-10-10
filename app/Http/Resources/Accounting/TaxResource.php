<?php

namespace App\Http\Resources\Accounting;

use Illuminate\Http\Resources\Json\JsonResource;

class TaxResource extends JsonResource
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
            'period_id' => $this->period_id,
            'employee_id' => $this->employee_id,
            'tax_group' => $this->tax_group,
            'untaxable' => $this->untaxable,
            'taxable' => $this->taxable,
            'tax_value' => $this->tax_value,
            'tax_key' => $this->tax_key
        ];
    }
}
