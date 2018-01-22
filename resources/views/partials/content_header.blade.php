<section class="content-header">
    <h1>
        {!! $title !!}
    </h1>
    <ol class="breadcrumb">
        <?php $index = 0; ?>
        @foreach($breadcrumbs as $name => $route)
            <?php
            if(is_array($route)){
                $routeName = array_shift($route);
                $url = route($routeName, $route);
            } else {
                $routeName = $route;
                $url = route($routeName);
            }
            ?>
            @if(count($breadcrumbs)-1 == $index)
                <li class="active">
                    @include('partials.route_icon', ['routeName' => $routeName])
                    {!! $name !!}
                </li>
            @else
                <li>
                    @include('partials.route_icon', ['routeName' => $routeName])
                    <a href="{!! $url !!}">{!! $name !!}</a>
                </li>
            @endif
            <?php $index++; ?>
        @endforeach
    </ol>
</section>