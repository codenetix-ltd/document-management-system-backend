<?php

namespace App\Repositories;

use App\Criteria\DocumentFilterCriteria;
use App\Criteria\DocumentSortingCriteria;
use App\Entities\Document;

/**
 * Class DocumentRepositoryEloquent.
 */
class DocumentRepositoryEloquent extends BaseRepository implements DocumentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Document::class;
    }
    
    public function getCriteriaList()
    {
        return [
            app(DocumentFilterCriteria::class),  
            app(DocumentSortingCriteria::class),  
        ];
    }
}
