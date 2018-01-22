@extends('layouts.index')

@section('content')
    @include('partials.add_edit_header', [
        'modelName' => 'model',
        'nameField' => 'full_name',
        'entityName' => 'User',
        'routePrefix' => 'users'
    ])
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">{!! trans('base.user.title') !!}</h3>
                    </div>
                    <!-- /.box-header -->
                @include('partials.message')
                @include('partials.errors')
                <!-- form start -->
                    <form class="form-horizontal" method="POST" enctype="multipart/form-data"
                          action="@if(isset($model)){!! route('users.update', $model->id) !!} @else {!! route('users.store') !!} @endif">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="form-group{!! $errors->has('full_name') ? ' has-error' : '' !!}">
                                <label for="full_name"
                                       class="col-sm-2 control-label">{!! trans('base.user.full_name') !!}</label>
                                <div class="col-sm-6">
                                    <input type="text" name="full_name" class="form-control" id="full_name"
                                           placeholder="{!! trans('base.user.full_name') !!}"
                                           value="{!! old('full_name', isset($model) ? $model->full_name : '') !!}">
                                </div>
                            </div>
                            <div class="form-group{!! $errors->has('email') ? ' has-error' : '' !!}">
                                <label for="email"
                                       class="col-sm-2 control-label">{!! trans('base.common.email') !!}</label>
                                <div class="col-sm-6">
                                    <input type="email" @if(isset($model)) disabled="disabled" @endif name="email"
                                           class="form-control" id="email"
                                           placeholder="{!! trans('base.common.email') !!}"
                                           value="{!! old('email', isset($model) ? $model->email : null) !!}">
                                </div>
                            </div>
                            <div class="form-group{!! $errors->has('factory_id') ? ' has-error' : '' !!}">
                                <label class="col-sm-2 control-label">User's factories</label>
                                <div class="col-sm-6">
                                    @include('partials.select', [
                                        'hideEmpty' => true,
                                        'class' => 'form-control input-sm',
                                        'name'=>'factory_id[]',
                                        'value' => old('factory_id', isset($model) ? $model->factories->pluck('id')->toArray() : []),
                                        'options' => $factories,
                                        'multi' => true
                                    ])
                                </div>
                            </div>
                            <div class="form-group{!! $errors->has('template_id') ? ' has-error' : '' !!}">
                                <label class="col-sm-2 control-label">User's templates</label>
                                <div class="col-sm-6">
                                    @include('partials.select', [
                                        'hideEmpty' => true,
                                        'class' => 'form-control input-sm',
                                        'name'=>'template_id[]',
                                        'value' => old('template_id', isset($model) ? $model->templates->pluck('id')->toArray() : []),
                                        'options' => $templates,
                                        'multi' => true
                                    ])
                                </div>
                            </div>
                            @if(authorizeActionForUser('role_toggle'))
                            <div class="form-group{!! $errors->has('role_id') ? ' has-error' : '' !!}">
                                <label for="roles"
                                       class="col-sm-2 control-label">{!! trans('base.common.roles') !!}</label>
                                <div class="col-sm-6">
                                    @include('partials.select', [
                                        'hideEmpty' => true,
                                        'class' => 'form-control',
                                        'name'=>'roles[]',
                                        'id' => 'roles',
                                        'options' => $roles,
                                        'columnName' => 'label',
                                        'value' => old('role_id', isset($model) ? $model->roles->pluck('id')->toArray() : null),
                                        'multi'=> true
                                     ])
                                </div>
                            </div>
                            @endif
                            <div class="form-group{!! $errors->has('password') ? ' has-error' : '' !!}">
                                <label for="password"
                                       class="col-sm-2 control-label">{!! trans('base.common.password') !!}</label>
                                <div class="col-sm-6">
                                    <input type="password" name="password" class="form-control" id="password"
                                           placeholder="{!! trans('base.common.password') !!}">
                                </div>
                            </div>
                            <div class="form-group{!! $errors->has('password_confirmation') ? ' has-error' : '' !!}">
                                <label for="password_confirmation"
                                       class="col-sm-2 control-label">{!! trans('base.common.repeat_password') !!}</label>
                                <div class="col-sm-6">
                                    <input type="password" name="password_confirmation" class="form-control"
                                           id="password_confirmation"
                                           placeholder="{!! trans('base.common.repeat_password') !!}">
                                </div>
                            </div>
                            <div class="form-group{!! $errors->has('file') ? ' has-error' : '' !!}">
                                <label for="file"
                                       class="col-sm-2 control-label">{!! trans('base.common.avatar') !!}</label>
                                <div class="col-sm-6">
                                    @if(isset($model) && $model->avatar)
                                        <div class="user-edit-avatar">
                                            <img class="img-thumbnail" style="margin-bottom: 10px;"
                                                 src="{!! $model->getAvatarUrl() !!}" width="100px;" height="100px;">
                                        </div>
                                    @endif
                                    <input name="file" type="file" class="form-control" id="file"
                                           value="{!! old('file') !!}"/>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            @if(isset($model))
                                <button type="submit"
                                        class="btn btn-success">{!! trans('base.common.update') !!}</button>
                            @else
                                <button type="submit"
                                        class="btn btn-success">{!! trans('base.common.create') !!}</button>
                            @endif
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

@push('js')
<script src="/plugins/select2/select2.full.min.js"></script>
<script src="/js/add_edit_user.js"></script>
@endpush