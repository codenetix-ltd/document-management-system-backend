@extends('layouts.index')

@section('content')
    @include('partials.add_edit_header', [
        'modelName' => 'label',
        'nameField' => 'name',
        'entityName' => 'Label',
        'routePrefix' => 'labels'
    ])
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">{!! trans('base.label.title') !!}</h3>
                    </div>
                    <!-- /.box-header -->
                @include('partials.message')
                @include('partials.errors')
                <!-- form start -->
                    <form class="form-horizontal" method="POST"
                          action="{!! isset($label) ? route('labels.update', ['id' => $label->id]) : route('labels.store') !!}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="form-group{!! $errors->has('name') ? ' has-error' : '' !!}">
                                <label for="name"
                                       class="col-sm-2 control-label">{!! trans('base.common.name') !!}</label>
                                <div class="col-sm-6">
                                    <input type="text" name="name" class="form-control" id="name"
                                           placeholder="{!! trans('base.label.label_name') !!}"
                                           value="{!! old('name', isset($label) ? $label->name : null) !!}">
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-success">
                                    @if(isset($label))
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
