<?php

namespace App\Http\Resources;

use App\Entities\DocumentVersion;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DocumentVersionResource
 * @package App\Http\Resources
 * 
 * @property DocumentVersion $resource
 */
class DocumentVersionResource extends JsonResource
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
            'id' => $this->resource->id, 
            'name' => $this->resource->name, 
            'templateId' => $this->resource->templateId, 
            'template' => new TemplateResource($this->resource->template), 
            'labelIds' => $this->resource->labels->pluck('id')->toArray(), 
            'fileIds' => $this->resource->files->pluck('id')->toArray(), 
            'files' => new FileCollectionResource($this->resource->files),
            'labels' => new LabelCollectionResource($this->resource->labels),
            'comment' => $this->resource->comment,
            'attributeValues' => new AttributeValueCollectionResource($this->resource->attributeValues),
            'createdAt' => $this->resource->createdAt->timestamp,
            'updatedAt' => $this->resource->updatedAt->timestamp,
        ];
    }
}
