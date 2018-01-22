<td>
    <table class="table table-bordered">
        <tr style="border-bottom: 2px solid #d2d6de !important" class="text-bold">
            <td class="@if($attribute->getValue()->getValue() == $row->getMinValue()) bg-info @endif @if($attribute->getValue()->getValue() == $row->getMaxValue()) bg-danger @endif">{!! $attribute->getValue()->getValue() !!}</td>
        </tr>
        <tr>
            <td class="@if($attribute->getValue()->getLeftDeviation() == $row->getMinValue()) bg-info @endif @if($attribute->getValue()->getLeftDeviation() == $row->getMaxValue()) bg-danger @endif">{!! $attribute->getValue()->getLeftDeviation() !!}</td>
        </tr>
        <tr>
            <td class="@if($attribute->getValue()->getRightDeviation() == $row->getMinValue()) bg-info @endif @if($attribute->getValue()->getRightDeviation() == $row->getMaxValue()) bg-danger @endif">{!! $attribute->getValue()->getRightDeviation() !!}</td>
        </tr>
    </table>
</td>