<div class="form-group form-group-table">
    <label for="attribute_name" class="col-sm-2 control-label">Table definition</label>
    <div class="col-sm-10">
        <div class="table-type-builder-wrapper" data-types="{!! htmlentities(\App\Type::all(['id', 'name', 'machine_name'])->filter(function($item){return $item->machine_name != 'table';})->toJSON()) !!}">
            <div class="table-type-builder-actions">
                <button class="btn btn-add-column btn-success btn-sm">
                    Add column
                </button>
                <button class="btn btn-add-row btn-success btn-sm">
                    Add row
                </button>
            </div>
            <table class="table table-bordered table-type-builder form-group-sm">
                <thead>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                </tfoot>
            </table>
            <input type="hidden" name="table_structure" value="{!! htmlentities(old('table_structure', isset($tableStructure) ? json_encode($tableStructure) : "")) !!}">
        </div>
    </div>
</div>

@push('css')
<link rel="stylesheet" href="/css/attribute_type_table.css"/>
@endpush

@push('js')
<script src="/js/attribute_type_table.js" type="application/javascript"></script>
<script type="application/javascript">
    var tableStructure = $('.table-type-builder-wrapper [name=table_structure]').val().length ? JSON.parse($('.table-type-builder-wrapper [name=table_structure]').val()) : null;
    console.log(tableStructure);
    new AttributeTypeTable($('.table-type-builder-wrapper'), tableStructure, $('.table-type-builder-wrapper').data('types'), function (structure) {
        $('.table-type-builder-wrapper [name=table_structure]').val(JSON.stringify(structure));
    });
</script>
@endpush

