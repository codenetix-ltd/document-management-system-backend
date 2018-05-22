<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccessTypeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'createdAt' => $this->createdAt->timestamp,
            'updatedAt' => $this->updatedAt->timestamp
        ];
    }
}
