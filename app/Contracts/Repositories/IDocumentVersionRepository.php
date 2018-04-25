<?php

namespace App\Contracts\Repositories;

use App\DocumentVersion;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
interface IDocumentVersionRepository extends RepositoryInterface
{
    public function findOrFail($id): DocumentVersion;
}
