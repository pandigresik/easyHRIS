<?php

namespace App\Http\Resources\Accounting;

use Illuminate\Http\Resources\Json\JsonResource;

class TaxGroupHistoryResource extends JsonResource
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
            'old_tax_group' => $this->old_tax_group,
            'new_tax_group' => $this->new_tax_group,
            'old_risk_ratio' => $this->old_risk_ratio,
            'new_risk_ratio' => $this->new_risk_ratio
        ];
    }
}
