<td data-format="{!! get_export_format_by_value($attribute->getValue()) !!}">
@include('partials.outputs.export.numeric', ['attribute' => $attribute])
</td>
@if($currentColumn->getTypeName() == 'value_with_deviations')
    <td></td>
    <td></td>
@endif