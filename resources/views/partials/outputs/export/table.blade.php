@if($attribute->getValue()->getRows()->isNotEmpty())
    <table cellspacing="0" cellpadding="0">
        @if(!$attribute->getValue()->getColumns()->isEmpty())
            <tr class="table-header">
                <td>{!! $attribute->getName() !!}</td>
                @foreach($attribute->getValue()->getColumns() as $currentColumn)
                    @include('partials.outputs.export.columns.'.$currentColumn->getTypeName())
                @endforeach
            </tr>
        @else
            <tr class="table-header">
                <td>{!! $attribute->getName() !!}</td>
                <td></td>
            </tr>
        @endif
        @foreach($attribute->getValue()->getRows() as $rowIndex => $currentRow)
            <tr>
                <td>{!! $currentRow->getName() !!}</td>
                @foreach ($currentRow->getCells() as $cellIndex => $currentCell)
                    @if(method_exists($currentCell, 'isLocked') && $currentCell->isLocked())
                        <td></td>
                        @continue
                    @endif

                    @if (empty($attribute->getValue()->getColumns()->get($cellIndex)))
                    @endif
                    @include('partials.outputs.export.table_outputs.'.$currentCell->getTypeName(), [
                        'attribute' => $currentCell,
                        'currentColumn' => $attribute->getValue()->getColumns()->get($cellIndex)
                    ])
                @endforeach
            </tr>
        @endforeach
    </table>
@endif
