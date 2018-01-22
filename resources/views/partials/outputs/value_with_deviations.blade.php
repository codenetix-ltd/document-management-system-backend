<table class="table table-bordered table-value-with-deviations">
    <tbody>
    <tr style="border-bottom: 2px solid #d2d6de !important">
        <td class="leaf-attribute-title-cell" width="1%;">Value:</td>
        <td>{!! $attribute->getValue()->getValue() !!}</td>
    </tr>
    <tr>
        <td class="leaf-attribute-title-cell" width="1%;">Deviation (-):</td>
        <td>{!! $attribute->getValue()->getLeftDeviation() !!}</td>
    </tr>
    <tr>
        <td class="leaf-attribute-title-cell" width="1%;">Deviation (+):</td>
        <td>{!! $attribute->getValue()->getRightDeviation() !!}</td>
    </tr>
    </tbody>
</table>