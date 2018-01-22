@if(!$attributes->isEmpty())
    <div class="box-header">
        <h3 class="box-title">Document attributes</h3>
    </div>
    <div class="box-body">
        @foreach($attributes as $attribute)
            <div class="form-group">
                <label class="col-md-2 control-label">{!! $attribute->getName() !!}</label>
                @if(!$attribute->isLocked())
                    @include('partials.inputs.column_inputs.'.$attribute->getTypeName(), ['attribute' => $attribute])
                @endif
            </div>
        @endforeach
    </div>
@endif