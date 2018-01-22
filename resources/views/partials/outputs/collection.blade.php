@foreach($attribute->getValue() as $attribute)
    @include('partials.outputs.'.$attribute->getTypeName(), ['attribute' => $attribute])
@endforeach
