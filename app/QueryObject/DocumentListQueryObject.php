<?php

namespace App\QueryObject;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class DocumentListQueryObject extends AQueryObject
{

    /**
     * @return array
     */
    protected function map()
    {
        return [
            'name' => 'actualVersion.name',
            'labelIds' => 'actualVersion.labelIds',
            'owner.fullName' => 'owner.full_name',
        ];
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model $model
     * @param string                                                                    $scope
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|Builder
     */
    protected function applyJoin($model, string $scope)
    {
        if ($scope === 'actualVersion') {
            return $model->join('document_versions as actualVersion', 'actualVersion.document_id', '=', 'documents.id')->where('actualVersion.is_actual', '=', '1');
        }

        if ($scope === 'actualVersion.template') {
            return $model->join('templates as template', 'actualVersion.template_id', '=', 'template.id');
        }

        if ($scope === 'owner') {
            return $model->leftJoin('users as owner', 'documents.owner_id', '=', 'owner.id');
        }

        return $model;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model $model
     * @param string                                                                    $field
     * @param array|string                                                              $value
     * @param string                                                                    $scope
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    protected function applyWhere($model, string $field, $value, string $scope)
    {
        if ($scope == 'actualVersion.labelIds') {
            $labelIdsAsFilteredString = implode(',', array_map(function ($item) {
                return sprintf('%d', $item);
            }, is_array($value) ? $value : [$value]));

            return $model->whereRaw(
                'actualVersion.id IN (SELECT document_version_id FROM document_version_label WHERE document_version_label.label_id IN ('.$labelIdsAsFilteredString.'))'
            );
        } else {
            return parent::applyWhere($model, $field, $value, $scope);
        }
    }
}
