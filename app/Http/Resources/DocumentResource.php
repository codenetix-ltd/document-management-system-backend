<?php

namespace App\Http\Resources;

use App\Entities\Document;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DocumentResource
 * @package App\Http\Resources
 *
 * @property Document $resource
 */
class DocumentResource extends JsonResource
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
            'ownerId' => $this->resource->ownerId,
            'createdAt' => $this->resource->createdAt->timestamp,
            'updatedAt' => $this->resource->updatedAt->timestamp,
            'substituteDocumentId' => $this->resource->substituteDocumentId,
            'actualVersion' => new DocumentVersionResource($this->resource->documentActualVersion),
            'version' => $this->resource->documentActualVersion->versionName,
            'owner' => new UserResource($this->resource->owner),
        ];
    }
}
