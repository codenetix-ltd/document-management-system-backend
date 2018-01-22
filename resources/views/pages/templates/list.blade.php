@extends('layouts.index')

@section('content')
    @include('partials.content_header', [
    'title' => 'Templates',
    'breadcrumbs' => [
        'Home' => 'home',
        'Templates' => 'templates.list'
    ]])
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header clearfix">
                        {{--<h3 class="box-title">{!! trans('base.common.templates') !!}</h3>--}}
                        <a class="btn btn-success btn-xs pull-right" href="{!! route('templates.create') !!}">
                            <i class="fa fa-plus"></i> {!! trans('base.template.add_template') !!}
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
                                    @forelse($templates as $template)
                                        <tr>
                                            <td>{!! $template->id !!}</td>
                                            <td>{!! $template->name !!}</td>
                                            <td>
                                                <a class="btn btn-success btn-xs"
                                                   href="{!! route('templates.edit', ['id' => $template->id]) !!}"><i
                                                            class="fa fa-edit"></i></a>
                                                @include('partials.delete_button', ['url' => route('templates.delete', [$template->id]), 'confirmText' => 'Do you really want to delete template '.$template->name.'?'])
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">{!! trans('base.common.empty') !!}</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                                {{ $templates->links() }}
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