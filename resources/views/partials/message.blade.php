@if (\Session::has('success'))
    <div class="box-body tide-message" style="display: none">
        <div class="callout callout-success">
            {!! \Session::get('success') !!}
        </div>
    </div>
@endif
@if (\Session::has('error'))
    <div class="box-body tide-message" style="display: none">
        <div class="callout callout-danger">
            {!! \Session::get('error') !!}
        </div>
    </div>
@endif