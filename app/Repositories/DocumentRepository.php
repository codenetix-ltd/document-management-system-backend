<?php

namespace App\Repositories;

use App\Contracts\Repositories\IDocumentRepository;
use App\Document;
use App\DocumentVersion;
use App\Repositories\Filters\DateFilter;
use App\Repositories\Filters\EqualsFilter;
use App\Repositories\Filters\OneOfFilter;
use App\Repositories\Filters\RelationFilter;
use App\Repositories\Filters\StartsWithFilter;
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
            (new EqualsFilter('id', $filters['id']))->apply($builder);
        }

        if(isset($filters['ownerId'])) {
            (new EqualsFilter('owner_id', $filters['ownerId']))->apply($builder);
        }

        if(isset($filters['name'])) {
            $startsWithFilter = (new StartsWithFilter('name', $filters['name']));
            (new RelationFilter($startsWithFilter, 'documentActualVersion'))->apply($builder);
        }

        if(isset($filters['templateIds'])) {
            $inFilter = new OneOfFilter('template_id', $filters['templateIds']);
            (new RelationFilter($inFilter, 'documentActualVersion'))->apply($builder);
        }

        if(isset($filters['labelIds'])) {
            $inFilter = new OneOfFilter('id', $filters['labelIds']);
            $documentVersionFilter = new RelationFilter($inFilter, 'tags');
            (new RelationFilter($documentVersionFilter, 'documentActualVersion'))->apply($builder);
        }

        $this->applyDateFilters($builder, 'createdAt', $filters, 'created_at');
        $this->applyDateFilters($builder, 'updatedAt', $filters, 'updated_at');

    }

    private function applyDateFilters(Builder $builder, $field, $filters, $dbAttribute)
    {
        if(isset($filters[$field.'.from'])) {
            (new DateFilter($dbAttribute, $filters[$field.'.from'], DateFilter::FROM))->apply($builder);
        }

        if(isset($filters[$field.'.to'])) {
            (new DateFilter($dbAttribute, $filters[$field.'.from'], DateFilter::TO))->apply($builder);
        }
    }

}
