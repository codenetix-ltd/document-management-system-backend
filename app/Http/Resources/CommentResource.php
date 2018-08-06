<?php

namespace App\Http\Resources;

use App\Entities\Comment;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CommentResource
 * @package App\Http\Resources
 *
 * @property Comment $resource
 */
class CommentResource extends JsonResource
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
            'user_id' => $this->resource->user_id,
            'commentable_id' => $this->resource->entity_id,
            'commentable_type' => $this->resource->entity_type,
            'parent_id' => $this->resource->parent_id,
            'body' => $this->resource->body,
            'created_at' => $this->resource->created_at->timestamp,
            'updated_at' => $this->resource->updated_at->timestamp
        ];
    }
}
