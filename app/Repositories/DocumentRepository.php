<?php

namespace App\Repositories;

use App\Contracts\Repositories\IDocumentRepository;
use App\Document;
use App\DocumentVersion;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class DocumentRepository extends EloquentRepository implements IDocumentRepository
{
    public function findOrFail($id): Document
    {
        return Document::findOrFail($id);
    }

    /**
     * @param array $filters
     *
     * @return LengthAwarePaginator
     */
    public function list($filters = []): LengthAwarePaginator
    {
        $query = Document::query();

        $this->applyFilters($query, $filters);

        return $query->paginate();
    }

    public function getActualVersionRelation(Document $document): DocumentVersion
    {
        return $document->documentActualVersion;
    }

    private function applyFilters(Builder $builder, $filters)
    {
        if(isset($filters['id'])) {
            $builder->where('id', '=', $filters['id']);
        }

        if(isset($filters['ownerId'])) {
            $builder->where('owner_id', '=', $filters['ownerId']);
        }

        if(isset($filters['name'])) {
            $fName = $filters['name'];
            $builder->whereHas('documentActualVersion', function($query) use($fName){
                $query->where('name', 'LIKE', $fName.'%');
            });
        }

        $this->applyDateFilters($builder, 'createdAt', $filters, 'created_at');
        $this->applyDateFilters($builder, 'updatedAt', $filters, 'updated_at');

    }

    private function applyDateFilters(Builder $builder, $field, $filters, $dbAttribute)
    {
        if(isset($filters[$field.'.from'])) {
            $builder->whereDate($dbAttribute, '>=', $filters[$field.'.from']);
        }

        if(isset($filters[$field.'.to'])) {
            $builder->whereDate($dbAttribute, '<=', $filters[$field.'.to']);
        }
    }

}
