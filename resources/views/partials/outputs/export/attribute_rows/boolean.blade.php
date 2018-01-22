<tr>
    <td>
        {!! $attribute->getName() !!}
    </td>
    <td>
        @include('partials.outputs.export.'.$attribute->getTypeName(), ['attribute' => $attribute])
    </td>
</tr>