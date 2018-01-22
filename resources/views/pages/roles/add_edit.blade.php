@extends('layouts.index')

@section('content')
    @include('partials.add_edit_header', [
        'modelName' => 'role',
        'nameField' => 'name',
        'entityName' => 'Role',
        'routePrefix' => 'roles'
    ])
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">{!! trans('base.role.title') !!}</h3>
                    </div>
                    <!-- /.box-header -->
                    @include('partials.message')
                    @include('partials.errors')
                    <div class="box-body">
                        <form method="POST" action="{!! isset($role) ? route('roles.update', ['id' => $role->id]) : route('roles.store') !!}">
                            {{ csrf_field() }}
                            <h3>General information</h3>
                            <hr>
                            <div class="row">
                                <div class="col-lg-5">
                                    <!-- form start -->
                                    <div class="form-group{!! $errors->has('label') ? ' has-error' : '' !!}">
                                        <label for="label"
                                               class="control-label">{!! trans('base.common.name') !!}</label>
                                        <input type="text" name="label" class="form-control" id="label"
                                               placeholder="{!! trans('base.role.role_name') !!}"
                                               value="{!! old('label', isset($role) ? $role->label : null) !!}">
                                    </div>
                                    <div class="form-group{!! $errors->has('factory_id') ? ' has-error' : '' !!}">
                                        <label for="label" class="control-label">Attached factories</label>
                                        @include('partials.select', [
                                            'hideEmpty' => true,
                                            'class' => 'form-control input-sm',
                                            'name'=>'factory_id[]',
                                            'value' => old('factory_id',  isset($role) ? $role->factories->pluck('id')->toArray() : null),
                                            'options' => $factories,
                                            'multi' => true
                                        ])
                                    </div>
                                    <div class="form-group{!! $errors->has('template_id') ? ' has-error' : '' !!}">
                                        <label for="label" class="control-label">Attached templates</label>
                                        @include('partials.select', [
                                            'hideEmpty' => true,
                                            'class' => 'form-control input-sm',
                                            'name'=>'template_id[]',
                                            'value' => old('template_id',  isset($role) ? $role->templates->pluck('id')->toArray() : null),
                                            'options' => $templates,
                                            'multi' => true
                                        ])
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-8">
                                    @isset($role)
                                    <h3>Permissions</h3>
                                    <hr>
                                    <div id="permission-list-wrapper">
                                        @include('pages.roles.partials.permission_list')
                                    </div>
                                    @endisset
                                    <div>
                                        <button type="submit" class="btn btn-success">
                                            @if(isset($role))
                                                {!! trans('base.common.update') !!}
                                            @else
                                                {!! trans('base.common.create') !!}
                                            @endif
                                        </button>
                                    </div>
                                    <!-- /.box-footer -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

@push('js')
<script src="/plugins/select2/select2.full.min.js"></script>
<script src="/js/add_edit_role.js"></script>
@endpush