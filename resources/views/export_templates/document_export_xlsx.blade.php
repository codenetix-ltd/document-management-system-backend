<html>
<link rel="stylesheet" href="{!! realpath(public_path('css/export_xlsx.css')) !!}">
<h1>{!! $document->getName() !!}</h1>
<h2>General information</h2>
<table>
    @foreach($document->getParameters() as $parameter)
        @if(key_exists($parameter->getName(), $filter['fields']))
            @include('partials.outputs.export.parameter_rows.'.$parameter->getTypeName(), ['attribute' => $parameter])
        @endif
    @endforeach
</table>
@if(!$document->getAttributes()->isEmpty())
    <h2>Attributes</h2>
    <table>
    @foreach($document->getAttributes() as $attribute)
        @if(key_exists($attribute->getId(), $filter['attributes']))
            @include('partials.outputs.export.attribute_rows.'.$attribute->getTypeName(), ['attribute' => $attribute])
        @endif
    @endforeach
    </table>
@endif
</html>