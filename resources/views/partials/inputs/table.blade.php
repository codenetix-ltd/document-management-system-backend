<table class="table table-bordered table-attributes">
    <thead>
    <tr>
        <th></th>
        @foreach($attribute->getValue()->getColumns() as $currentColumn)
            <th>{!! $currentColumn->getName() !!}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($attribute->getValue()->getRows() as $currentRow)
        <tr>
            <td class="leaf-attribute-title-cell">{!! $currentRow->getName() !!}</td>
            @foreach ($currentRow->getCells() as $currentCell)
                @if($currentCell->isLocked())
                    <td class='cell-locked'></td>
                    @continue
                @endif
                    @include('partials.inputs.table_inputs.'.$currentCell->getTypeName(), ['attribute' => $currentCell])
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>