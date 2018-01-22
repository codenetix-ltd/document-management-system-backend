(function (window, $) {
    initListPage(function () {
            $('#dataTableBuilder').data('selected-row-ids', selected);
            var selected = [];
            $(document).on('click', '#dataTableBuilder th.select-checkbox', function (e) {
                $(this).closest('tr').toggleClass('selected');
                if ($(this).closest('tr').hasClass('selected')) {
                    var selected = $('#dataTableBuilder tbody tr').addClass('selected').map(function(){return $(this).data('id'); }).toArray();
                }
                else {
                    $('#dataTableBuilder tbody tr').removeClass('selected');
                }
                $('#dataTableBuilder').data('selected-row-ids', selected);
            });

            $(document).on('click', '#dataTableBuilder tbody td:not(:last-child)', function (e) {
                e.stopPropagation();
                e.preventDefault();
                var selected = $('#dataTableBuilder').data('selected-row-ids') || [];

                var id = $(this).closest('tr').data('id');
                var index = $.inArray(id, selected);

                if (index === -1) {
                    selected.push(id);
                } else {
                    selected.splice(index, 1);
                }

                $("#dataTableBuilder th.select-checkbox").closest('tr').removeClass('selected');
                $(this).closest('tr').toggleClass('selected');
                $('#dataTableBuilder').data('selected-row-ids', selected);

            });

            window.LaravelDataTables = window.LaravelDataTables || {};
            window.LaravelDataTables["%1$s"] = $("#%1$s").DataTable(%2$s);
        });

    })(window, jQuery);