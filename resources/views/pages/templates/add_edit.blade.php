@extends('layouts.index')

@section('content')
    @include('partials.add_edit_header', [
        'modelName' => 'template',
        'nameField' => 'name',
        'entityName' => 'Template',
        'routePrefix' => 'templates'
    ])
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">{!! trans('base.template.title') !!}</h3>
                    </div>
                    <!-- /.box-header -->
                @include('partials.message')
                @include('partials.errors')
                <!-- form start -->
                    <form class="form-horizontal" method="POST"
                          action="{!! isset($template) ? route('templates.update', ['id' => $template->id]) : route('templates.store') !!}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="form-group{!! $errors->has('name') ? ' has-error' : '' !!}">
                                <label for="name"
                                       class="col-sm-2 control-label">{!! trans('base.common.name') !!}</label>
                                <div class="col-sm-6">
                                    <input type="text" name="name" class="form-control" id="name"
                                           placeholder="{!! trans('base.template.template_name') !!}"
                                           value="{!! old('name', isset($template) ? $template->name : null) !!}">
                                </div>
                            </div>
                            @isset($template)
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{!! trans('base.common.attributes') !!}</label>
                                <div class="col-sm-6">
                                    <table class="table table-bordered" id="attributesTable">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>{!! trans('base.common.name') !!}</th>
                                            <th>{!! trans('base.common.type') !!}</th>
                                            <th>{!! trans('base.common.actions') !!}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($attributes as $attribute)
                                            <tr data-id="{!! $attribute->id !!}">
                                                <td class="sortable-pointer">
                                                    <i class="fa fa-arrows-v"></i>
                                                </td>
                                                <td>{!! $attribute->name !!}</td>
                                                <td>{!! $attribute->type->machine_name !!}</td>
                                                <td class="fit-column">
                                                    <a href="{!! route('template_attributes.edit', [$template->id, $attribute->id]) !!}"
                                                       class="btn btn-success btn-xs">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    @include('partials.delete_button', ['url' => route('attributes.delete', [$attribute->id]), 'confirmText' => 'Do you really want to delete attribute '.$attribute->name.'?'])
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="empty-placeholder">
                                                <td colspan="4" class="text-center">{!! trans('base.common.empty') !!}</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                    <input type="hidden" name="orders">
                                    <a class="btn btn-primary pull-right btn-sm"
                                       href="{!! route('template_attributes.create', ['templateId' => $template->id]) !!}">
                                        <i class="fa fa-plus"></i>
                                        {!! trans('base.template.add_attribute') !!}
                                    </a>
                                </div>
                                @endisset
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-success">
                                    @if(isset($template))
                                        {!! trans('base.common.update') !!}
                                    @else
                                        {!! trans('base.common.create') !!}
                                    @endif
                                </button>
                            </div>
                            <!-- /.box-footer -->
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->

@endsection

@push('css')
<link rel="stylesheet" href="/css/sortable_attributes_table.css">
@endpush

@push('js')
<script src="/js/create_template.js"></script>
@endpush
