<td>
    @include('partials.outputs.export.file', ['attribute' => $attribute])
</td>
@if(isset($currentColumn) && $currentColumn->getTypeName() == 'value_with_deviations')
    <td></td>
    <td></td>
@endif