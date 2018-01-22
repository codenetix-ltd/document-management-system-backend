@extends('layouts.index')

@section('content')
    @include('partials.content_header', ['title' => 'Documents',
    'breadcrumbs' => [
        'Home' => 'home',
        'Document list' => 'documents.list'
    ]])
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box box-success">
                    <div class="box-body">
                        <div class="document-filters-wrapper datatables-filters-wrapper">
                            <div class="document-filters datatables-filters">
                                <div class="row">
                                    <div class="form-group col-lg-1 col-md-4 col-sm-6">
                                        <div class="input-group input-group-sm">
                                        <span class="input-group-addon">
                                            ID:
                                        </span>
                                            <input id="filter-id-input" data-filter="filter-id" type="text"
                                                   class="form-control input-sm filter-column filter-type-text"
                                                   placeholder="Id">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-3 col-md-4 col-sm-6">
                                        <div class="input-group input-group-sm">
                                        <span class="input-group-addon">
                                            Name:
                                        </span>
                                            <input id="filter-name-input" data-filter="filter-name" type="text"
                                                   class="form-control input-sm filter-column filter-type-text"
                                                   placeholder="Document name">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-4 col-sm-6">
                                        <div class="input-group input-group-sm">
                                        <span class="input-group-addon">
                                            Owner:
                                        </span>
                                            <input id="filter-owner-input" data-filter="filter-owner" type="text"
                                                   class="form-control input-sm filter-column filter-type-text"
                                                   placeholder="User name">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-4 col-sm-6">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-addon">Template</span>

                                            @include('partials.select', [
                                                'hideEmpty' => true,
                                                'class' => 'form-control input-sm filter-column filter-type-select',
                                                'name'=>'template_id[]',
                                                'id' => 'filter-template-input',
                                                'options' => $templates,
                                                'multi'=> true,
                                                'value' => '',
                                                'attrs' => 'data-filter="filter-template"'
                                            ])
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-4 col-sm-6">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-addon">Factory</span>
                                            @include('partials.select', [
                                                    'hideEmpty' => true,
                                                    'class' => 'form-control input-sm filter-column filter-type-select',
                                                    'name'=>'factory_id[]',
                                                    'id' => 'filter-factory-input',
                                                    'options' => $factories,
                                                    'multi'=> true,
                                                    'value' => '',
                                                    'attrs' => 'data-filter="filter-factory"'
                                                ])
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-2 col-md-4 col-sm-6">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-addon">Labels</span>
                                            @include('partials.select', [
                                                    'hideEmpty' => true,
                                                    'class' => 'form-control input-sm filter-column filter-type-select',
                                                    'name'=>'label_id[]',
                                                    'id' => 'filter-label-input',
                                                    'options' => $labels,
                                                    'multi'=> true,
                                                    'value' => '',
                                                    'attrs' => 'data-filter="filter-label"'
                                                ])
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-3 col-md-6 col-sm-6">
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
                                    <div class="form-group col-lg-2 col-md-6 col-sm-6">
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
                                    <input type="hidden" id="filter-created-at-input" data-filter="filter-created-at"
                                           class="filter-type-hidden">
                                    <div class="form-group col-lg-3 col-md-6 col-sm-6">
                                        <div class="input-group input-group-sm">
                                        <span class="input-group-addon">
                                            Updated at:
                                        </span>
                                            <input type="text" id="updated-at-start" readonly="readonly"
                                                   class="form-control daterangepicker-readonly updated-at-input daterangepicker-input"
                                                   value="" placeholder="Date from" data-date-format="yyyy-mm-dd">
                                            <span class="input-group-btn">
                                                <button class="btn btn btn-warning btn-xs btn-clear-input"
                                                        data-clear="updated-at-start">
                                                <i class="fa fa-eraser"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-6 col-sm-6">
                                        <div class="input-group input-group-sm">
                                            <input type="text" id="updated-at-end" readonly="readonly"
                                                   class="form-control daterangepicker-readonly updated-at-input daterangepicker-input"
                                                   value="" placeholder="Date to" data-date-format="yyyy-mm-dd">
                                            <span class="input-group-btn">
                                                <button class="btn btn btn-warning btn-xs btn-clear-input"
                                                        data-clear="updated-at-end">
                                                    <i class="fa fa-eraser"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <input type="hidden" id="filter-updated-at-input" data-filter="filter-updated-at"
                                           class="filter-type-hidden">
                                    <div class="form-group col-lg-1 col-md-2 col-sm-2">
                                        <div class="input-group input-group-sm">
                                        <span class="input-group-addon">
                                            Archived:
                                        </span>
                                            <span class="input-group-addon">
                                            <input id="filter-deleted-at-input" type="checkbox"
                                                   data-filter="filter-deleted-at"
                                                   class="filter-type-checkbox" value="true">
                                                </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-inline pull-right document-actions">
                            @if(authorizeActionForDocument('document_create'))
                                <div class="form-group">
                                    <a href="{!! route('documents.create') !!}" class="btn btn-success form-control"><i
                                                class="fa fa-plus"></i> {!! trans('base.document.add_new') !!}
                                    </a>
                                </div>
                            @endif
                            <div class="form-group">
                                <button id="mass-archive" class="btn btn-primary btn-warning form-control"
                                        data-confirm-content-text="Do you really want to archive these documents?"
                                        data-url="{!! route('api.documents.mass_archive') !!}"
                                        data-confirm-title-text="Confirmation"
                                        data-success-msg="documents has been archived"
                                        data-document-list-url="{!! route('api.documents.list') !!}"
                                        data-document-required="New actual document selection is required!"
                                        data-find-document-placeholder="Choose document">
                                    <i class="fa fa-book"></i> Archive selected
                                </button>
                            </div>
                            <div class="form-group">
                                <button id="mass-delete" class="btn btn-primary btn-danger form-control"
                                        data-confirm-content-text="Do you really want to delete these documents?"
                                        data-url="{!! route('api.documents.mass_delete') !!}"
                                        data-confirm-title-text="Confirmation"
                                        data-success-msg="documents has been deleted">
                                    <i class="fa fa-book"></i> Delete selected
                                </button>
                            </div>

                            <div class="form-group">
                                <button id="mass-compare" class="btn btn-primary form-control" data-documents-required="At least 2 documents should be selected for compare">
                                    <i class="fa fa-copy"></i> Compare selected
                                </button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    @include('partials.message')
                                    {!! $dataTable->table([], true) !!}
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
    <script id="archive-confirmation-body-template" type="jquery/tmpl">
        <p>Do you really want to archive selected documents?</p>
        <hr>
        <div class="form-horizontal">
          <div class="form-group">
             <label class="col-md-4 control-label">New actual document:</label>
             <div class="col-md-8">
             <select class="form-control" name="document_id">
             </div>
          </div>
        </div>

    </script>
@endsection

@push('css')
<link rel="stylesheet" href="/plugins/datatables/dataTables.bootstrap.css">
{{--<link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">--}}
<link rel="stylesheet" href="/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="/plugins/datatables/select.dataTables.min.css">

@endpush
@push('js')
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="/plugins/select2/select2.full.min.js"></script>
<script src="/plugins/daterangepicker/moment.js"></script>
{{--<script src="/plugins/daterangepicker/daterangepicker.js"></script>--}}
<script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="/vendor/datatables/buttons.server-side.js"></script>
<script src="/js/document_list.js"></script>
{!! $dataTable->scripts() !!}
@endpush