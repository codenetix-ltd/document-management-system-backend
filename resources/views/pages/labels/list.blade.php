@extends('layouts.index')

@section('content')
    @include('partials.content_header', [
    'title' => 'Labels',
    'breadcrumbs' => [
        'Home' => 'home',
        'Labels' => 'labels.list'
    ]])
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header clearfix">
                        <a class="btn btn-success btn-xs pull-right" href="{!! route('labels.create') !!}">
                            <i class="fa fa-plus"></i> {!! trans('base.label.add_label') !!}
                        </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12">
                                @include('partials.message')
                                <table class="table table-bordered table-striped table-responsive">
                                    <thead>
                                    <tr>
                                        <th>{!! trans('base.common.id') !!}</th>
                                        <th>{!! trans('base.common.name') !!}</th>
                                        <th>{!! trans('base.common.actions') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($labels as $label)
                                        <tr>
                                            <td>{!! $label->id !!}</td>
                                            <td>{!! $label->name !!}</td>
                                            <td>
                                                <a class="btn btn-success btn-xs"
                                                   href="{!! route('labels.edit', ['id' => $label->id]) !!}"><i
                                                            class="fa fa-edit"></i></a>
                                                @include('partials.delete_button', ['url' => route('labels.delete', [$label->id]), 'confirmText' => 'Do you really want to delete label '.$label->name.'?'])
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">{!! trans('base.common.empty') !!}</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                                {{ $labels->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection