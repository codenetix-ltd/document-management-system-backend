<?php

namespace App\Contracts\Repositories;

use App\DocumentVersion;
use Illuminate\Support\Collection;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
interface IDocumentVersionRepository extends RepositoryInterface
{
    public function findOrFail($id): DocumentVersion;
    public function syncTags(DocumentVersion $model, array $tagIds): array;
    public function detachTags(DocumentVersion $model);

    public function syncFiles(DocumentVersion $model, array $fileIds): array;
    public function detachFiles(DocumentVersion $model);

    public function list(int $documentId): Collection;
}
