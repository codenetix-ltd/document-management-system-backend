@foreach($attribute->getValue() as $attribute)
    @include('partials.outputs.export.'.$attribute->getTypeName(), ['attribute' => $attribute])
@endforeach
