<td>
    @include('partials.outputs.export.string', ['attribute' => $attribute])
</td>
@if($currentColumn->getTypeName() == 'value_with_deviations')
    <td></td>
    <td></td>
@endif