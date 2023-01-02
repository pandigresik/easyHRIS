<?php

namespace App\Http\Resources\Base;

use Illuminate\Http\Resources\Json\JsonResource;

class ApprovalResource extends JsonResource
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
            'model' => $this->model,
            'reference' => $this->reference,
            'status' => $this->status,
            'comment' => $this->comment,
            'sequence' => $this->sequence,
            'user_id' => $this->user_id
        ];
    }
}
