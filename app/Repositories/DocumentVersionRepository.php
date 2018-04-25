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
}
