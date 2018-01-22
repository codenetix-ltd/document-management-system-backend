<?php

namespace App\DataTables;

use App\Helpers\DataTableParametersParserHelper;
use App\Log;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Lang;
use Yajra\Datatables\Services\DataTable;

class LogsDataTable extends DataTable
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
            ->addColumn('url', function (Log $log) {
                return $log->reference ? view('partials.links.'.$log->reference_type, ['id' => $log->reference->id, 'name' => $log->reference->getName()]) : 'deleted';
            })
            ->addColumn('user', function (Log $log) {
                return $log->user ? view('partials.links.user', ['id' => $log->user->id, 'name' => $log->user->getName()]) : 'deleted';
            })
            ->rawColumns(['url', 'user'])
            ->filterColumn('reference_type', function ($query) {})
            ->filterColumn('user', function ($query) {})
            ->filterColumn('created_at', function ($query) {})
        ;
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Log::query()->select('logs.*');

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
            ->parameters([
                'dom' => 'Bfrtip',
                'order' => [[0, 'desc']],
                "pageLength" => 30,
                "buttons" => [
                ],
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
            Lang::get('base.common.user') => ['name' => 'user', 'data' => 'user', 'id' => 'filter-user'],
            Lang::get('base.common.action') => ['name' => 'body', 'data' => 'body', "id" => "filter-body"],
            Lang::get('base.common.url') => ['name' => 'url', 'data' => 'url', 'searchable' => false, 'orderable' => false],
            Lang::get('base.common.reference_type') => ['name' => 'reference_type', 'data' => 'reference_type', "id" => "filter-reference-type", 'orderable' => false],
            Lang::get('base.common.created_at') => ['name' => 'created_at', 'data' => 'created_at', 'id' => 'filter-created-at'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'logs_' . time();
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    private function applyFilters(Builder $query)
    {
        $createdAt = DataTableParametersParserHelper::parseDateRange('created_at', $this->request()->columns());
        if (!is_null($createdAt)) {
            if (!is_null($createdAt->getStartDate())) {
                $query->where('created_at', '>=', $createdAt->getStartDate());
            }
            if (!is_null($createdAt->getEndDate())) {
                $query->where('created_at', '<=', $createdAt->getEndDate());
            }
        }

        $referenceNames = DataTableParametersParserHelper::parseSelect('reference_type', $this->request()->columns());
        if (!is_null($referenceNames)) {
            $query->whereIn('reference_type', $referenceNames);
        }

        $userName = DataTableParametersParserHelper::parseTextInput('user', $this->request()->columns());
        if (!is_null($userName)) {
            $query->whereHas(
                'user', function ($query) use ($userName) {
                return $query->where('full_name', 'like',  "%$userName%");
            });
        }

        return $query;
    }
}
