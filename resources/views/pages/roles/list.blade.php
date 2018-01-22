@extends('layouts.index')

@section('content')
    @include('partials.content_header', [
    'title' => 'Roles',
    'breadcrumbs' => [
        'Home' => 'home',
        'Roles' => 'roles.list'
    ]])
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header clearfix">
                        <a class="btn btn-success btn-xs pull-right" href="{!! route('roles.create') !!}">
                            <i class="fa fa-plus"></i> {!! trans('base.role.add_role') !!}
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
                                    @forelse($roles as $role)
                                        <tr>
                                            <td>{!! $role->id !!}</td>
                                            <td>{!! $role->label !!}</td>
                                            <td>
                                                <a class="btn btn-success btn-xs"
                                                   href="{!! route('roles.edit', ['id' => $role->id]) !!}"><i
                                                            class="fa fa-edit"></i></a>
                                                @include('partials.delete_button', ['url' => route('roles.delete', [$role->id]), 'confirmText' => 'Do you really want to delete role '.$role->name.'?'])
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">{!! trans('base.common.empty') !!}</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                                {{ $roles->links() }}
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
