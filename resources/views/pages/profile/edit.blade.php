@extends('layouts.index')

@section('content')
    @include('partials.content_header', [
            'title' => 'My profile',
            'breadcrumbs' => [
                'Home' => 'home',
                'My profile' => ['profile.edit', $model->id]
            ]])
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
                @include('partials.errors')
                <!-- form start -->
                    <form class="form-horizontal" method="POST" enctype="multipart/form-data"
                          action="{!! route('profile.update', $model->id) !!}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="form-group">
                                <label for="full_name"
                                       class="col-sm-2 control-label">{!! trans('base.user.full_name') !!}</label>
                                <div class="col-sm-6">
                                    <input type="text" name="full_name" class="form-control" id="full_name"
                                           placeholder="{!! trans('base.user.full_name') !!}"
                                           value="{!! old('full_name', isset($model) ? $model->full_name : '') !!}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email"
                                       class="col-sm-2 control-label">{!! trans('base.common.email') !!}</label>
                                <div class="col-sm-6">
                                    <input type="email" @if(isset($model)) disabled="disabled" @endif name="email"
                                           class="form-control" id="email"
                                           placeholder="{!! trans('base.common.email') !!}"
                                           value="{!! old('email', isset($model) ? $model->email : null) !!}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="factoryId"
                                       class="col-sm-2 control-label">{!! trans('base.common.factory') !!}</label>
                                <div class="col-sm-6">
                                    @include('partials.select', ['class' => 'form-control', 'name'=>'factory_id', 'id' => 'factoryId', 'options' => $factories, 'value' => old('factory_id', isset($model) ? $model->factory_id : null) ])
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password"
                                       class="col-sm-2 control-label">{!! trans('base.common.password') !!}</label>
                                <div class="col-sm-6">
                                    <input type="password" name="password" class="form-control" id="password"
                                           placeholder="{!! trans('base.common.password') !!}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation"
                                       class="col-sm-2 control-label">{!! trans('base.common.repeat_password') !!}</label>
                                <div class="col-sm-6">
                                    <input type="password" name="password_confirmation" class="form-control"
                                           id="password_confirmation"
                                           placeholder="{!! trans('base.common.repeat_password') !!}">
                                </div>
                            </div>
                            <div class="form-group">
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