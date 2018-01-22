@extends('layouts.index')

@section('content')
    @include('partials.content_header', [
    'title' => 'Users',
    'breadcrumbs' => [
        'Home' => 'home',
        'Users' => 'users.list'
    ]])
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header clearfix">
                        {{--<h3 class="box-title">{!! trans('base.common.users') !!}</h3>--}}
                        @if(authorizeActionForUser('user_create'))
                            <a href="{!! route('users.create') !!}" class="btn btn-success btn-xs pull-right">
                                <i class="fa fa-plus"></i> {!! trans('base.user.add_user') !!}
                            </a>
                        @endif
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12">
                                @include('partials.message')
                                <table class="table table-bordered table-striped table-responsive responsive">
                                    <thead>
                                    <tr class="replace-inputs">
                                        <th class="all">{!! trans('base.common.id') !!}</th>
                                        <th class="all">{!! trans('base.user.full_name') !!}</th>
                                        <th class="all">{!! trans('base.common.email') !!}</th>
                                        <th class="all">{!! trans('base.common.actions') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{!! $user->id !!}</td>
                                            <td>{!! $user->full_name !!}</td>
                                            <td>{!! $user->email !!}</td>
                                            <td>
                                                @if(authorizeActionForUser('user_update', $user))
                                                    <a class="btn-success btn btn-xs"
                                                       href="{!! route('users.edit', $user->id) !!}"><i
                                                                class="fa fa-edit"></i></a>
                                                @endif
                                                @if(authorizeActionForUser('user_delete', $user))
                                                    @include('partials.delete_button', ['url' => route('users.delete', [$user->id]), 'confirmText' => 'Do you really want to delete user \''.$user->full_name.'\'?'])
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {!! $users->render() !!}
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