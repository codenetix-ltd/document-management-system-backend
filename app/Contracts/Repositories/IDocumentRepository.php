<?php

namespace App\Contracts\Repositories;

use App\Document;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
interface IDocumentRepository extends RepositoryInterface
{
    public function findOrFail($id): Document;
}
