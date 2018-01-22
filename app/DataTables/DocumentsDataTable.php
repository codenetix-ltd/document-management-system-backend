<?php

namespace App\DataTables;

use App\Document;
use App\Helpers\DataTableParametersParserHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Yajra\Datatables\Services\DataTable;

class DocumentsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @return \Yajra\Datatables\Engines\BaseEngine
     */
    public function dataTable()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('factoriesList', function (Document $document) {
                return $document->factories->map(function ($factory) {
                    return $factory->name;
                })->implode('<br>');
            })
            ->addColumn('labelsList', function (Document $document) {
                return $document->labels->map(function ($label) {
                    return $label->name;
                })->implode('<br>');
            })
            ->addColumn('document', function (Document $document) {
                return $document;
            })
            ->addColumn('checkbox', '', false)
            ->addColumn('action', 'pages.documents.actions', false)
            ->rawColumns(['action', 'checkbox', 'factoriesList', 'labelsList'])
            ->filterColumn('template.name', function ($query) {
            })
            ->filterColumn('factoriesList', function ($query) {
            })
            ->filterColumn('labelsList', function ($query) {
            })
            ->filterColumn('created_at', function ($query) {
            })
            ->filterColumn('updated_at', function ($query) {
            })
            ->filterColumn('deleted_at', function ($query) {
            })->withTrashed();

    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Document::query()->with(['owner', 'template', 'factories', 'labels'])->select('documents.*');

        $query = $this->applyFilters($query);

        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax('')
            ->addAction([
                'width' => '85px',
                'title' => 'Actions'
            ])
            ->addColumnBefore([
                'data' => 'checkbox',
                'name' => '',
                'title' => '',
                'orderable' => false,
                'searchable' => false,
                'exportable' => false,
                'class' => 'select-checkbox'
            ])
            ->parameters([
                'dom' => 'Bfrtip',
                'order' => [[1, 'desc']],
                "pageLength" => 15,
                "buttons" => [

                ],
                "rowCallback" => "function(row, data) {
                    var selected = $('#dataTableBuilder').data('selected-row-ids');
                    $(row).data('id', data.id);
                    if ( $.inArray(data.id, selected) !== -1 ) {
                        $(row).addClass('selected');
                    }
                 }",
                'initComplete' => "function () {
                    this.api().columns().every(function () {
                        var column = this;
                        var header = column.header();
                        var filter = $(header).attr('id');

                        if ($('.datatables-filters input[data-filter=\"'+filter+'\"].filter-type-hidden').size()) {
                            var input = $('.datatables-filters input[data-filter=\"'+filter+'\"].filter-type-hidden');
                            $(input).on('change', function () {
                                column.search($(this).val(), false, false, true).draw();
                            });
                        }
                        if ($('.datatables-filters input[data-filter=\"'+filter+'\"].filter-type-text').size()) {
                            var input = $('.datatables-filters input[data-filter=\"'+filter+'\"].filter-type-text');
                            $(input).on('change keyup', function () {
                                column.search($(this).val(), false, false, true).draw();
                            });
                        }
                        if ($('.datatables-filters select[data-filter=\"'+filter+'\"].filter-type-select').size()) {
                            var select = $('.datatables-filters select[data-filter=\"'+filter+'\"].filter-type-select');
                            select.on('change', function () {
                                column.search($(this).val(), false, false, true).draw();
                            });
                        }
                        if ($('.datatables-filters input[data-filter=\"'+filter+'\"].filter-type-checkbox').size()) {
                            var input = $('.datatables-filters input[data-filter=\"'+filter+'\"].filter-type-checkbox');
                            $(input).on('change keyup', function () {
                                column.search($(this).is(':checked'), false, false, true).draw();
                            });
                        }
                    });
                }",
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Lang::get('base.common.id') => ['name' => 'id', 'data' => 'id', 'id' => 'filter-id'],
            Lang::get('base.common.name') => ['name' => 'name', 'data' => 'name', "id" => "filter-name"],
            Lang::get('base.document.owner') => ['name' => 'owner.full_name', 'data' => 'owner.full_name', "id" => "filter-owner"],
            Lang::get('base.common.template') => ['name' => 'template.name', 'data' => 'template.name', "id" => "filter-template"],
            Lang::get('base.common.factory') => ['name' => 'factoriesList', 'data' => 'factoriesList', "id" => "filter-factory", 'orderable' => false],
            Lang::get('base.common.label') => ['name' => 'labelsList', 'data' => 'labelsList', "id" => "filter-label", 'orderable' => false],
            Lang::get('base.common.created_at') => ['name' => 'created_at', 'data' => 'created_at', 'id' => 'filter-created-at'],
            Lang::get('base.common.updated_at') => ['name' => 'updated_at', 'data' => 'updated_at', 'id' => 'filter-updated-at'],
            Lang::get('base.common.deleted_at') => ['name' => 'deleted_at', 'data' => 'deleted_at', 'id' => 'filter-deleted-at', 'visible' => false]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'documents_' . time();
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    private function applyFilters(Builder $query)
    {
        $templateIds = DataTableParametersParserHelper::parseSelect('template.name', $this->request()->columns());
        if (!is_null($templateIds)) {
            $query->whereHas(
                'template', function ($query) use ($templateIds) {
                return $query->whereIn('id', $templateIds);
            });
        }

        $factoryIds = DataTableParametersParserHelper::parseSelect('factoriesList', $this->request()->columns());
        if (!is_null($factoryIds)) {
            $query->whereHas(
                'factories', function ($query) use ($factoryIds) {
                return $query->whereIn('id', $factoryIds);
            });
        }

        $labelIds = DataTableParametersParserHelper::parseSelect('labelsList', $this->request()->columns());
        if (!is_null($labelIds)) {
            $query->whereHas(
                'labels', function ($query) use ($labelIds) {
                return $query->whereIn('id', $labelIds);
            });
        }

        $isDeleted = DataTableParametersParserHelper::parseTernarySelect('deleted_at', $this->request()->columns());
        if (true === $isDeleted) {
            $query->onlyTrashed();
        }

        $createdAt = DataTableParametersParserHelper::parseDateRange('created_at', $this->request()->columns());
        if (!is_null($createdAt)) {
            if (!is_null($createdAt->getStartDate())) {
                $query->where('created_at', '>=', $createdAt->getStartDate());
            }
            if (!is_null($createdAt->getEndDate())) {
                $query->where('created_at', '<=', $createdAt->getEndDate());
            }
        }

        $updatedAt = DataTableParametersParserHelper::parseDateRange('updated_at', $this->request()->columns());
        if (!is_null($updatedAt)) {
            if (!is_null($updatedAt->getStartDate())) {
                $query->where('updated_at', '>=', $updatedAt->getStartDate());
            }
            if (!is_null($updatedAt->getEndDate())) {
                $query->where('updated_at', '<=', $updatedAt->getEndDate());
            }
        }

        return $query;
    }
}
