<?php

namespace App\Repositories;

use App\Contracts\Repositories\IDocumentRepository;
use App\Document;
use App\DocumentVersion;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class DocumentRepository extends EloquentRepository implements IDocumentRepository
{
    public function findOrFail($id): Document
    {
        return Document::findOrFail($id);
    }

    public function list(): LengthAwarePaginator
    {
        return Document::paginate();
    }

    public function getActualVersionRelation(Document $document): DocumentVersion
    {
        return $document->documentActualVersion;
    }

    public function find($id): ?Document
    {
        return Document::find($id);
    }
}
