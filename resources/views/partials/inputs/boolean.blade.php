<input type="checkbox" name="attribute[{!!$attribute->getId()!!}]" @if(old('attribute.'.$attribute->getId(), $attribute->getValue())) checked @endif/>