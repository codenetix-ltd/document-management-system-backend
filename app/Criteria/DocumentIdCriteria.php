<?php

namespace App\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class DocumentIdCriteria.
 *
 * @package namespace App\Criteria;
 */
class DocumentIdCriteria implements CriteriaInterface
{
    private $documentId;

    public function __construct($documentId)
    {
        $this->documentId = $documentId;
    }

    /**
     * Apply criteria in query repository
     *
     * @param Model|Builder              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('document_id', '=', $this->documentId);
        return $model;
    }
}
