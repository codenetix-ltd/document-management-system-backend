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
                        <button class="btn btn-success btn-sm btn-manage-filter">
                            <i class="fa fa-cog"></i> Manage filters
                        </button>
                        <div class="document-filters form-inline">
                            <div class="form-group">
                                <label>ID:</label>
                                <select class="form-control input-sm">
                                    <option>Any</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Name:</label>
                                <select class="form-control input-sm">
                                    <option>Any</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Type:</label>
                                <select class="form-control input-sm">
                                    <option>Any</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Owner:</label>
                                <select class="form-control input-sm">
                                    <option>Any</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Labels:</label>
                                <select class="form-control input-sm">
                                    <option>Any</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Factory:</label>
                                <select class="form-control input-sm">
                                    <option>Any</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Created at:</label>
                                <select class="form-control input-sm">
                                    <option>Any</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Updated at:</label>
                                <select class="form-control input-sm">
                                    <option>Any</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header clearfix">
                        <div class="pull-right">
                            <button class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i> Create document
                            </button>
                            <button class="btn btn-warning btn-sm">
                                <i class="fa fa-book"></i> Archive selected
                            </button>
                            <button class="btn btn-default btn-sm">
                                <i class="fa fa-filter"></i>
                            </button>
                            <button class="btn btn-default btn-sm">
                                <i class="fa fa-refresh"></i>
                            </button>
                            <button class="btn btn-default btn-sm">
                                <i class="fa fa-cog"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12">
                                @include('partials.message')
                                <table class="table table-bordered table-striped table-responsive">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>{!! trans('base.common.id') !!}</th>
                                        <th>{!! trans('base.common.name') !!}</th>
                                        <th>{!! trans('base.document.actual_version') !!}</th>
                                        <th>{!! trans('base.document.owner') !!}</th>
                                        <th>{!! trans('base.common.factory') !!}</th>
                                        <th>{!! trans('base.common.template') !!}</th>
                                        <th>{!! trans('base.common.actions') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($documents as $document)
                                        <tr>
                                            <td class="export-checkbox">
                                                <input type="checkbox">
                                            </td>
                                            <td>{!! $document->id !!}</td>
                                            <td>{!! $document->name !!}</td>
                                            <td>{!! $document->documentActualVersion->version_name !!}</td>
                                            <td>{!! $document->owner->full_name !!}</td>
                                            <td>{!! $document->factories->pluck('name')->implode(', ') !!}</td>
                                            <td>{!! $document->template->name !!}</td>
                                            <td>
                                                <a class="btn btn-default btn-xs"
                                                   href="#"><i
                                                            class="fa fa-upload"></i></a>
                                                <a class="btn btn-primary btn-xs"
                                                   href="{!! route('documents.view', ['id' => $document->id]) !!}"><i
                                                            class="fa fa-eye"></i></a>
                                                @if(authorizeActionForDocument('document_update', $document))
                                                    <a class="btn btn-success btn-xs"
                                                       href="{!! route('documents.edit', ['id' => $document->id]) !!}"><i
                                                                class="fa fa-edit"></i></a>
                                                @endif
                                                @if(authorizeActionForDocument('document_delete', $document))
                                                    @include('partials.delete_button', ['url' => route('documents.delete', [$document->id]), 'confirmText' => 'Do you really want to delete document '.$document->name.'?'])
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">{!! trans('base.common.empty') !!}</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                                {{ $documents->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </section>
    <!-- /.content -->
@endsection

@push('css')
<link rel="stylesheet" href="/plugins/datatables/dataTables.bootstrap.css">
@endpush

@push('js')
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="/plugins/select2/select2.min.js"></script>
<script type="application/javascript">
    $('.document-filters select').select2({
        width: 100
    });
    $('.table').DataTable();
</script>
@endpush