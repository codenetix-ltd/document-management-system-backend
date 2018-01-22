@if ($errors->any())
    <div class="box-body">
        <div class="callout callout-danger">
            <h4>{!! trans('base.common.validation_errors_detected') !!}:</h4>
            <ul>
                @foreach ($errors->all() as $id => $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

