<table class="table table-bordered">
    @if(!$attribute->getValue()->getColumns()->isEmpty())
        <thead>
        <tr>
            <?php $width = 80 / $attribute->getValue()->getColumns()->count() ?>
            <th style="width: 20%"></th>
            @foreach($attribute->getValue()->getColumns() as $currentColumn)
                <th style="width: {!! $width !!}%">
                    {!! $currentColumn->getName() !!}
                </th>
            @endforeach
        </tr>
        </thead>
    @endif
    <tbody>
    @forelse($attribute->getValue()->getRows() as $currentRow)
        <tr>
            <td class="leaf-attribute-title-cell">{!! $currentRow->getName() !!}</td>
            @foreach ($currentRow->getCells() as $currentCell)
                @if(method_exists($currentCell, 'isLocked') && $currentCell->isLocked())
                    <td class='cell-locked'></td>
                    @continue
                @endif
                    @include('partials.outputs.table_outputs.'.$currentCell->getTypeName(), ['attribute' => $currentCell])
            @endforeach
        </tr>
    @empty
        <tr>
            <td class="text-center">Empty</td>
        </tr>
    @endforelse
    </tbody>
</table>