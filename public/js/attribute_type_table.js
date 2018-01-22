function AttributeTypeTable(selector, structure, types, onUpdate) {

    var minRowsNum = 1;
    var minColNum = 1;

    $('.btn-add-column', selector).on('click', function (e) {
        e.preventDefault();

        addColumnToExistingStructure();
        renderStructure();
    });

    $('.btn-add-row', selector).bind('click', function (e) {
        e.preventDefault();

        addRowToExistingStructure();
        renderStructure();
    });

    if (!structure) {
        structure = getDefaultStructure();
        addColumnToExistingStructure();
        addColumnToExistingStructure();
        addRowToExistingStructure();
        addRowToExistingStructure();
    } else {
        structure = decorateStructureByMetaFields(structure);
    }

    function getDefaultStructure() {
        return decorateStructureByMetaFields({
            'columns': [],
            'rows': [],
        });
    }

    function decorateStructureByMetaFields(structure) {
        structure['removed_rows'] = [];
        structure['removed_columns'] = [];
        structure['types'] = types;
        return structure;
    }

    function addColumnToExistingStructure() {
        structure.columns.push({
            name: 'Enter title',
            type_id: 1
        });

        $.each(structure.rows, function () {
            this.data.push({
                is_locked: false
            });
        });
    }

    function addRowToExistingStructure() {
        structure.rows.push({
            name: 'Enter title',
            data: $.map(structure.columns, function () {
                return {
                    is_locked: false
                };
            })
        });
    }

    function renderStructure() {
        $('thead', selector).html('');
        $('tbody', selector).html('');
        $('tfoot', selector).html('');
        //Header
        var nameRow = $('<tr/>', {class: 'table-type-builder__thead_name-row'}),
            typeRow = $('<tr/>', {class: 'table-type-builder__thead_type-row'});

        $('thead', selector).append(nameRow).append(typeRow);

        nameRow.append($('<th/>', {class: 'table-type-builder__name_cell'}));
        typeRow.append($('<th/>', {class: 'table-type-builder__name_cell'}));

        $.each(structure.columns, function (colIndex) {
            nameRow.append(makeEditableColumnNameTh(colIndex, this.name));
            typeRow.append($('<th/>').append(makeTypeSelect(colIndex, this.type_id, structure.types)));
        });

        nameRow.append($('<th/>', {class: 'table-type-builder__actions_cell'}));
        typeRow.append($('<th/>', {class: 'table-type-builder__actions_cell'}));

        //Body
        var body = $('.table-type-builder tbody');
        $.each(structure.rows, function (rowIndex, v) {
            var tr = $('<tr/>');
            body.append(tr);
            tr.append(makeEditableRowNameTd(rowIndex, this.name));
            $.each(this.data, function (colIndex) {
                var trContent = $('<td/>').append(makeCellLockButton(rowIndex, colIndex, this.is_locked));

                if(!this.is_locked){
                    trContent.append(makeCellTypeSelect(colIndex, rowIndex, this.type_id, structure.types))
                }

                tr.append(trContent);
            });
            tr.append($('<td/>', {class: 'table-type-builder__actions_cell'}).append(makeRemoveRowButton(rowIndex, v.id)));
        });

        //Footer
        var footerRow = $('<tr/>', {class: 'table-type-builder__tbody__actions-row'});
        $('tfoot', selector).append(footerRow);

        footerRow.append($('<th/>'));
        $.each(structure.columns, function (i, v) {
            footerRow.append($('<th/>').append(makeRemoveColumnButton(i, v.id)));
        });
        footerRow.append($('<th/>'));

        onUpdate(structure);
    }

    renderStructure(structure);


    function checkForRowUniqName(name) {
        var isUniq = true;
        $.each(structure.rows, function () {
            if ($.trim(this.name) == name) {
                isUniq = false;
            }
        });
        return isUniq;
    }

    function checkForColUniqName(name) {
        var isUniq = true;
        $.each(structure.columns, function () {
            if ($.trim(this.name) == name) {
                isUniq = false;
            }
        });
        return isUniq;
    }

    function makeEditableRowNameTd(rowIndex, name) {
        var td = $('<td/>', {
            contenteditable: true,
            text: name
        });

        td.blur(function () {
            if (structure.rows[rowIndex].name !== $(this).html()) {
                // if(!checkForRowUniqName(structure.rows[rowIndex].name)){
                //     alert('Row name is not unique');
                //     return;
                // }
                structure.rows[rowIndex].name = $(this).html();
                renderStructure();
            }
        });

        return td;
    }

    function makeEditableColumnNameTh(colIndex, name) {
        var th = $('<th/>', {
            contenteditable: true,
            text: name
        });

        th.blur(function () {
            if (structure.columns[colIndex].name !== $(this).html()) {
                // if(!checkForColUniqName(structure.columns[colIndex].name)){
                //     alert('Column name is not unique');
                //     return;
                // }
                structure.columns[colIndex].name = $(this).html();
                renderStructure();
            }
        });

        return th;
    }

    function makeRemoveRowButton(index, id) {
        var removeButton = $('<button/>', {class: 'btn btn-xs btn-danger btn-remove-column'}).append($('<i/>', {class: 'fa fa-trash'}));

        if (structure.rows.length <= minRowsNum) {
            removeButton.prop('disabled', true);
        }

        removeButton.on('click', function () {
            if (id) {
                structure.removed_rows.push(id);
            }
            structure.rows.splice(index, 1);
            renderStructure();
        });
        return removeButton;
    }

    function makeRemoveColumnButton(index, id) {
        var removeButton = $('<button/>', {class: 'btn btn-xs btn-danger btn-remove-column'}).append($('<i/>', {class: 'fa fa-trash'}));

        if (structure.columns.length <= minColNum) {
            removeButton.prop('disabled', true);
        }

        removeButton.on('click', function () {
            if (id) {
                structure.removed_columns.push(id);
            }
            structure.columns.splice(index, 1);
            $.each(structure.rows, function () {
                this.data.splice(index, 1);
            });

            renderStructure();
        });

        return removeButton;
    }

    function makeCellLockButton(rowIndex, colIndex, is_locked) {
        var lockButton = $('<button/>', {class: 'btn btn-xs btn-warning btn-lock-cell'}).append($('<i/>', {class: 'fa fa-lock'}));
        $('i', lockButton).attr('class', is_locked ? 'fa fa-unlock' : 'fa fa-lock');
        lockButton.on('click', function (e) {
            e.preventDefault();
            structure.rows[rowIndex].data[colIndex].is_locked = !is_locked;
            renderStructure();
        });

        return lockButton;
    }


    function makeCellTypeSelect(colIndex, rowIndex, value, options) {
        var select = $('<select/>', {class: 'form-control'});

        var option = $("<option></option>")
            .attr("value", "")
            .text("Inherit");

        var isSelected = false;
        if (!value || value == structure.columns[colIndex].type_id) {
            isSelected = true;
            option.prop('selected', true);
        }
        select.append(option);

        $.each(options, function () {
            var option = $("<option></option>")
                .attr("value", this.id)
                .text(this.name);

            if (!isSelected && value == this.id) {
                option.prop('selected', true);
            }

            select.append(option);
        });

        select.on('change', function () {
            if(!this.value){
                delete structure.rows[rowIndex].data[colIndex].type_id;
            } else {
                structure.rows[rowIndex].data[colIndex].type_id = parseInt(this.value);
            }
            renderStructure();
        });

        return select;
    }

    function makeTypeSelect(colIndex, value, options) {
        var select = $('<select/>', {class: 'form-control'});
        $.each(options, function () {
            var option = $("<option></option>")
                .attr("value", this.id)
                .text(this.name);

            if (value == this.id) {
                option.prop('selected', true);
            }

            select.append(option);
        });

        select.on('change', function () {
            structure.columns[colIndex].type_id = this.value;
            renderStructure();
        });

        return select;
    }
}

