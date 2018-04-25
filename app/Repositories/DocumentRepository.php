<?php

namespace App\Repositories;

use App\Contracts\Repositories\IDocumentRepository;
use App\Document;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class DocumentRepository extends EloquentRepository implements IDocumentRepository
{
    public function findOrFail($id): Document
    {
        return Document::findOrFail($id);
    }
}
