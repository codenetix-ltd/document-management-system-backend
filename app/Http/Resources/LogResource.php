<?php

namespace App\Http\Resources;

use App\Entities\Log;

/**
 * Class LogResource
 * @package App\Http\Resources
 *
 * @property Log $resource
 */
class LogResource extends AbstractSingularResource
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
            'id' => $this->resource->id,
            'user' => new UserResource($this->resource->user),
            'body' => $this->resource->body,
            'link' => $this->resource->reference ? [
                'title' => $this->resource->reference->getTitle(),
                'url' => $this->resource->reference->getTable() . '/' . $this->resource->reference->id
            ] : null,
            'referenceType' => $this->resource->referenceType,
            'referenceId' => $this->resource->referenceId,
            'createdAt' => $this->resource->createdAt->timestamp,
            'updatedAt' => $this->resource->updatedAt->timestamp,
        ];
    }
}
