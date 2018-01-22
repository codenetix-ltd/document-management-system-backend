@extends('layouts.index')

@section('content')
    @include('partials.content_header', ['title' => 'Logs',
    'breadcrumbs' => [
        'Home' => 'home',
        'Logs list' => 'logs.list'
    ]])
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box box-success">
                    <div class="box-body">
                        <div class="datatables-filters-wrapper">
                            <div class="datatables-filters">
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <div class="input-group">
                                        <span class="input-group-addon">
                                            ID:
                                        </span>
                                            <input id="filter-id-input" data-filter="filter-id" type="text"
                                                   class="form-control input-sm filter-column filter-type-text"
                                                   placeholder="Id">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <div class="input-group">
                                        <span class="input-group-addon">
                                            User:
                                        </span>
                                            <input id="filter-user-input" data-filter="filter-user" type="text"
                                                   class="form-control input-sm filter-column filter-type-text"
                                                   placeholder="User">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <div class="input-group">
                                        <span class="input-group-addon">
                                            Action:
                                        </span>
                                            <input id="filter-body-input" data-filter="filter-body" type="text"
                                                   class="form-control input-sm filter-column filter-type-text"
                                                   placeholder="Action">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-addon">Type</span>
                                            @include('partials.select', [
                                                    'hideEmpty' => true,
                                                    'class' => 'form-control input-sm filter-column filter-type-select',
                                                    'name'=>'reference_type[]',
                                                    'id' => 'filter-reference-type-input',
                                                    'options' => $references,
                                                    'multi'=> true,
                                                    'value' => '',
                                                    'attrs' => 'data-filter="filter-reference-type"'
                                                ])
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-addon">
                                                Created at:
                                            </span>
                                            <input type="text" id="created-at-start" readonly="readonly"
                                                   class="form-control daterangepicker-readonly created-at-input daterangepicker-input"
                                                   value="" placeholder="Date from" data-date-format="yyyy-mm-dd">
                                            <span class="input-group-btn">
                                                <button class="btn btn btn-warning btn-xs btn-clear-input"
                                                        data-clear="created-at-start"><i
                                                            class="fa fa-eraser"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="input-group input-group-sm">
                                            <input type="text" id="created-at-end" readonly="readonly"
                                                   class="form-control daterangepicker-readonly created-at-input daterangepicker-input"
                                                   value="" placeholder="Date to" data-date-format="yyyy-mm-dd">
                                            <span class="input-group-btn">
                                            <button class="btn btn btn-warning btn-xs btn-clear-input"
                                                    data-clear="created-at-end">
                                                <i class="fa fa-eraser"></i>
                                            </button>
                                            </span>
                                        </div>
                                    </div>
                                    <input type="hidden" id="filter-created-at-input" data-filter="filter-created-at" class="filter-type-hidden">


                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    @include('partials.message')
                                    {!! $dataTable->table([ 'id' => 'LogsDataTable'], true) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@push('css')
<link rel="stylesheet" href="/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.2/css/select.dataTables.min.css">

@endpush
@push('js')
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="/plugins/select2/select2.min.js"></script>
<script src="/plugins/daterangepicker/moment.js"></script>
<script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="/vendor/datatables/buttons.server-side.js"></script>
<script src="/js/log_list.js"></script>
{!! $dataTable->scripts() !!}
@endpush