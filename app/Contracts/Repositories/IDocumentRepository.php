<?php

namespace App\Contracts\Repositories;

use App\Document;
use App\DocumentVersion;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
interface IDocumentRepository extends RepositoryInterface
{
    public function findOrFail($id): Document;
    public function find($id): ?Document;
    public function list(): LengthAwarePaginator;
    public function getActualVersionRelation(Document $document):DocumentVersion;
}
