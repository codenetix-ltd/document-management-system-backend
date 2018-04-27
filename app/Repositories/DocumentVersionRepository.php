<?php

namespace App\Repositories;

use App\Contracts\Repositories\IDocumentVersionRepository;
use App\DocumentVersion;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class DocumentVersionRepository extends EloquentRepository implements IDocumentVersionRepository
{
    public function findOrFail($id): DocumentVersion
    {
        return DocumentVersion::findOrFail($id);
    }

    public function syncTags(DocumentVersion $model, array $tagIds): array
    {
        return $model->tags()->sync($tagIds);
    }

    public function detachTags(DocumentVersion $model)
    {
        $model->tags()->detach();
    }

    public function syncFiles(DocumentVersion $model, array $fileIds): array
    {
        return $model->files()->sync($fileIds);

    }

    public function detachFiles(DocumentVersion $model)
    {
        $model->files()->detach();
    }
}
