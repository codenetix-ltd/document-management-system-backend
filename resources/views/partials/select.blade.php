<select name="{!! $name !!}" @if(isset($id)) id="{!! $id !!}" @endif class="{!! $class !!}" @if(isset($multi) && $multi) multiple @endif @if(isset($disabled) && $disabled) disabled @endif @if(isset($attrs)) {!! $attrs !!} @endif>
    @if(!isset($hideEmpty) || !$hideEmpty)
    <option value="">Choose selection</option>
    @endif
@foreach($options as $option)
    <?php $optionId = $option[isset($idKey) ? $idKey : 'id']; ?>
    <option value="{!! $optionId !!}" @if(isset($value) && (is_array($value) ? in_array($optionId, $value) : ($value == $optionId))) selected @endif>
    @if(isset($columnName))
        {!! $option[$columnName] !!}
    @else
        {!! $option['name'] !!}
    @endif
    </option>
@endforeach
</select>