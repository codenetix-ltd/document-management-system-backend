<div class="form-group deviation-value-form-group">
    <div class="col-xs-4">
        <input type="text" class="form-control" name="attribute[{!!$attribute->getId()!!}][left]" value="{!! old('attribute.'.$attribute->getId().'.left', $attribute->getValue()->getLeftDeviation()) !!}" placeholder="-" data-type="{!! $attribute->getTypeName() !!}" data-deviation-field-type="left"/>
    </div>
    <div class="col-xs-4">
        <input type="text" class="form-control" name="attribute[{!!$attribute->getId()!!}][value]" value="{!! old('attribute.'.$attribute->getId().'.value', $attribute->getValue()->getValue()) !!}" placeholder="Value" data-type="{!! $attribute->getTypeName() !!}" data-deviation-field-type="value"/>
    </div>
    <div class="col-xs-4">
        <input type="text" class="form-control" name="attribute[{!!$attribute->getId()!!}][right]" value="{!! old('attribute.'.$attribute->getId().'.right', $attribute->getValue()->getRightDeviation()) !!}" placeholder="+" data-type="{!! $attribute->getTypeName() !!}" data-deviation-field-type="right"/>
    </div>
</div>