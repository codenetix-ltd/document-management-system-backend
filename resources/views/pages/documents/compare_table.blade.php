<h2 class="compare-document-tables-title">{!! $document->documentActualVersion->document->name !!}</h2>
<ul class="compare-document-tables-info">
    <li>{!! $document->factories->pluck('name')->implode(', ')!!}</li>
    <li>{!! $document->owner->full_name !!}</li>
</ul>
@if(!$attributes->isEmpty())
    <table class="table table-responsive table-striped table-compare">
        <tbody>
        @foreach($attributes as $attribute)
            @if($attribute->type->machine_name != 'table')
                <tr>
                    <td>
                        {!! $attribute->name !!}
                        @include('partials.outputs.'.strtolower($types->where('id', $attribute['type_id'])->first()->name), ['attribute' => $attribute])
                    </td>
                    <td>
                        @include('partials.outputs.'.strtolower($types->where('id', $attribute['type_id'])->first()->name), ['attribute' => $attribute])
                    </td>
                </tr>
            @else
                @include('partials.outputs.table_plain', ['attribute' => $attribute])
            @endif
        @endforeach
        </tbody>
    </table>
@endif
