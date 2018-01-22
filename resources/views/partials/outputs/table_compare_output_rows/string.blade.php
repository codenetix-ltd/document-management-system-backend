<tr>
    <td class="leaf-attribute-title-cell">
        {!! $row->getName() !!}
    </td>
    @foreach($row->getAttributes() as $i => $attribute)
        @include('partials.outputs.table_compare_output_cells.'.$attribute->getTypeName(), ['attribute' => $attribute, 'row' => $row])
    @endforeach
</tr>