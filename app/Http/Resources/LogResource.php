<?php

namespace App\Http\Resources;

use App\Entities\Log;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class LogResource
 * @package App\Http\Resources
 *
 * @property Log $resource
 */
class LogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->resource->id,
            'user' => (new UserResource($this->resource->user)),
            'action' => $this->resource->body,
            'link' => [
                'title' => $this->resource->reference->getTitle(),
                'url' => $this->resource->reference->getTable() . '/' . $this->resource->reference->id
            ],
            "referenceType" => $this->resource->referenceType,
            "referenceId" => $this->resource->referenceId,
            "createdAt" => $this->resource->createdAt->timestamp,
            "updatedAt" => $this->resource->updatedAt->timestamp,
        ];
    }
}
