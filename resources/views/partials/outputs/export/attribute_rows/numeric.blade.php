<tr>
    <td>
        {!! $attribute->getName() !!}
    </td>
    <td data-format="{!! get_export_format_by_value($attribute->getValue()) !!}">
        @include('partials.outputs.export.'.$attribute->getTypeName(), ['attribute' => $attribute])
    </td>
</tr>