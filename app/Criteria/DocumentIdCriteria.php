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
    /**
     * @var integer
     */
    private $documentId;

    /**
     * DocumentIdCriteria constructor.
     * @param integer $documentId
     */
    public function __construct(int $documentId)
    {
        $this->documentId = $documentId;
    }

    /**
     * Apply criteria in query repository
     *
     * @param Model|Builder       $model
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
