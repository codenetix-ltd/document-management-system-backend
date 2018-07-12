<?php

namespace App\Http\Resources;

use App\Entities\Document;
use App\System\AuthBuilders\AuthorizerFactory;
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
            'actions' => $this->buildAvailableActions()
        ];
    }

    private function buildAvailableActions()
    {
        $actions = [];
        $authorizer = AuthorizerFactory::make('document', $this->resource);

        if ($authorizer->isAuthorize('document_view')) {
            array_push($actions, 'view');
        }
        if ($authorizer->isAuthorize('document_update')) {
            array_push($actions, 'update');
        }
        if ($authorizer->isAuthorize('document_delete')) {
            array_push($actions, 'delete');
        }
        if ($authorizer->isAuthorize('document_archive')) {
            array_push($actions, 'archive');
        }

        return $actions;
    }
}
