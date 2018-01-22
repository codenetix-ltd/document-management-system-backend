<tr>
    <td class="leaf-attribute-title-cell">
        <table class="table table-bordered table-value-with-deviations">
            <tr style="border-bottom: 2px solid #d2d6de !important">
                <td class="leaf-attribute-title-cell">{!! $row->getName() !!}:</td>
            </tr>
            <tr>
                <td class="leaf-attribute-title-cell">Deviation (-):</td>
            </tr>
            <tr>
                <td class="leaf-attribute-title-cell">Deviation (+):</td>
            </tr>
        </table>
    </td>
    @foreach($row->getAttributes() as $i => $attribute)
        @include('partials.outputs.table_compare_output_cells.'.$attribute->getTypeName(), ['attribute' => $attribute, 'row' => $row])
    @endforeach
</tr>