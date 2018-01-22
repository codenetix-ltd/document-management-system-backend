<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>FoodUnion | DMS</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/plugins/select2/select2.min.css"/>
    <link rel="stylesheet" href="/plugins/select2/select2-bootstrap.min.css"/>
    <link rel="stylesheet" href="/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="/dist/css/skins/_all-skins.min.css">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.3/jquery-confirm.min.css">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link rel="stylesheet" href="/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css">

    <link rel="stylesheet" href="/css/app.css">

@stack('css')
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
<div class="wrapper">
    <header class="main-header">
        <!-- Logo -->
        <a href="{!! url('/') !!}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>D</b>MS</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>FoodUnion</b> DMS</span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{!! Auth::user()->getAvatarURL() !!}" class="user-image"
                                 alt="User Image">
                            <span class="hidden-xs">
                                {!! Auth::user()->full_name !!}
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="{!! Auth::user()->getAvatarURL() !!}" class="img-circle"
                                     alt="User Image">
                                <p>
                                    {!! Auth::user()->full_name !!}
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{!! route('profile.edit', Auth::user()->id) !!}"
                                       class="btn btn-default btn-flat">{!! trans('base.common.edit_profile') !!}</a>
                                </div>
                                <div class="pull-right">
                                    <form action="{!! route('logout') !!}" method="POST">
                                        {{ csrf_field() }}
                                        <button class="btn btn-default btn-flat"
                                                type="submit">{!! trans('base.common.logout') !!}</button>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{!! Auth::user()->getAvatarURL() !!}" class="img-circle"
                         alt="{!! trans('base.common.user_image') !!}">
                </div>
                <div class="pull-left info">
                    <p>{!! Auth::user()->full_name !!}</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> {!! trans('base.common.online') !!}</a>
                </div>
            </div>

            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                @if(has_permission('documents_menu'))
                    <li class="treeview @if(starts_with(Route::current()->getName(),'documents')) active @endif">
                        <a href="#">
                            <i class="fa fa-book"></i> <span>{!! trans('base.common.documents') !!}</span>
                        </a>
                        <ul class="treeview-menu">
                            <li @if(Route::current()->getName() == 'documents.list') class="active" @endif>
                                <a href="{!! route('documents.list') !!}">
                                    <i class="fa fa-list"></i> <span>{!! trans('base.common.list_all') !!}</span>
                                </a>
                            </li>
                            @if(authorizeActionForDocument('document_create'))
                                <li @if(Route::current()->getName() == 'documents.create') class="active" @endif>
                                    <a href="{!! route('documents.create') !!}">
                                        <i class="fa fa-plus"></i> <span>{!! trans('base.common.add_new') !!}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(has_permission('templates_menu'))
                    <li class="treeview @if(starts_with(Route::current()->getName(),'templates')) active @endif">
                        <a href="#">
                            <i class="fa fa-file-text"></i> <span>{!! trans('base.common.templates') !!}</span>
                        </a>
                        <ul class="treeview-menu">
                            <li @if(Route::current()->getName() == 'templates.list') class="active" @endif>
                                <a href="{!! route('templates.list') !!}">
                                    <i class="fa fa-list"></i> <span>{!! trans('base.common.list_all') !!}</span>
                                </a>
                            </li>
                            <li @if(Route::current()->getName() == 'templates.create') class="active" @endif>
                                <a href="{!! route('templates.create') !!}">
                                    <i class="fa fa-plus"></i> <span>{!! trans('base.common.add_new') !!}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(has_permission('users_menu'))
                    <li class="treeview @if(starts_with(Route::current()->getName(),'users')) active @endif">
                        <a href="#">
                            <i class="fa fa-user"></i> <span>{!! trans('base.common.users') !!}</span>
                        </a>
                        <ul class="treeview-menu">
                            <li @if(Route::current()->getName() == 'users.list') class="active" @endif>
                                <a href="{!! route('users.list') !!}">
                                    <i class="fa fa-list"></i> <span>{!! trans('base.common.list_all') !!}</span>
                                </a>
                            </li>
                            @if(authorizeActionForUser('user_create'))
                                <li @if(Route::current()->getName() == 'users.create') class="active" @endif>
                                    <a href="{!! route('users.create') !!}">
                                        <i class="fa fa-plus"></i> <span>{!! trans('base.common.add_new') !!}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(has_permission('labels_menu'))
                    <li class="treeview @if(starts_with(Route::current()->getName(),'labels')) active @endif">
                        <a href="#">
                            <i class="fa fa-tags"></i> <span>{!! trans('base.common.labels') !!}</span>
                        </a>
                        <ul class="treeview-menu">
                            <li @if(Route::current()->getName() == 'labels.list') class="active" @endif>
                                <a href="{!! route('labels.list') !!}">
                                    <i class="fa fa-list"></i> <span>{!! trans('base.common.list_all') !!}</span>
                                </a>
                            </li>
                            <li @if(Route::current()->getName() == 'labels.create') class="active" @endif>
                                <a href="{!! route('labels.create') !!}">
                                    <i class="fa fa-plus"></i> <span>{!! trans('base.common.add_new') !!}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(has_permission('roles_menu'))
                    <li class="treeview @if(starts_with(Route::current()->getName(),'roles')) active @endif">
                        <a href="#">
                            <i class="fa fa-shield"></i> <span>{!! trans('base.common.roles') !!}</span>
                        </a>
                        <ul class="treeview-menu">
                            <li @if(Route::current()->getName() == 'roles.list') class="active" @endif>
                                <a href="{!! route('roles.list') !!}">
                                    <i class="fa fa-list"></i> <span>{!! trans('base.common.list_all') !!}</span>
                                </a>
                            </li>
                            <li @if(Route::current()->getName() == 'roles.create') class="active" @endif>
                                <a href="{!! route('roles.create') !!}">
                                    <i class="fa fa-plus"></i> <span>{!! trans('base.common.add_new') !!}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(has_permission('logs_menu'))
                    <li class="treeview @if(starts_with(Route::current()->getName(),'logs')) active @endif">
                        <a href="#">
                            <i class="fa fa-history"></i> <span>{!! trans('base.common.logs') !!}</span>
                        </a>
                        <ul class="treeview-menu">
                            <li @if(Route::current()->getName() == 'logs.list') class="active" @endif>
                                <a href="{!! route('logs.list') !!}">
                                    <i class="fa fa-list"></i> <span>{!! trans('base.common.list_all') !!}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content', 'empty data')
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 0.1 alpha
        </div>
        <strong>Copyright &copy; 2017 <a href="http://codenetix.com">Codenetix</a>.</strong>
    </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- jQueryUI v1.11.4 -->
<script src="/plugins/jQueryUI/jquery-ui.min.js"></script>

<script src="/plugins/debounce/debounce.min.js"></script>

<!-- Bootstrap 3.3.6 -->
<script src="/bootstrap/js/bootstrap.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.3/jquery-confirm.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="/plugins/bootstrap-multiselect/js/bootstrap-multiselect.js"></script>

<script src="/plugins/typehead/typehead.min.js"></script>

<!-- AdminLTE App -->
<script src="/dist/js/app.min.js"></script>

<script src="/js/app.js"></script>

@yield('js')
@stack('js')

</body>
</html>
