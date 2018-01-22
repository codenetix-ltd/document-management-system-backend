@if($attribute->getValue()->getRows()->isNotEmpty())
    </table>
    @include('partials.outputs.export.table', ['attribute' => $attribute])
    <table cellspacing="0" cellpadding="0">
@endif