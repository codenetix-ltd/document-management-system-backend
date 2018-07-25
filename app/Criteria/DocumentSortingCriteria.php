<?php

namespace App\Criteria;


/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class DocumentSortingCriteria extends RelationSortingCriteria
{
    protected function addJoin($table, $foreignKey, $model)
    {
        if($table == 'document_versions') {
            return $model
                ->leftJoin('document_versions', 'document_versions.document_id', '=', 'documents.id')
                ->where('document_versions.is_actual', '=', '1')
            ;   
        }
        
        return parent::addJoin($table, $foreignKey, $model);
    }


}
