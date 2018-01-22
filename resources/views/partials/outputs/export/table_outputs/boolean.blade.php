<td>
    @include('partials.outputs.export.boolean', ['attribute' => $attribute])
</td>

@if($currentColumn->getTypeName() == 'value_with_deviations')
    <td></td>
    <td></td>
@endif