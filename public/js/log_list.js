function initListPage(onInitCb) {
    $("#filter-reference-type-input").select2({
        minimumResultsForSearch: -1
    });

    var filterCreatedAt = $("#filter-created-at-input");
    $('#created-at-start, #created-at-end').datepicker({}).on('changeDate', function(e){
        $(this).datepicker('hide');
        filterCreatedAt.val($('#created-at-start').val() + '|' + $('#created-at-end').val());
        filterCreatedAt.change();
    });

    $('.btn-clear-input').on('click', function () {
         var id = $(this).attr('data-clear');
         var input = $('#' + id);
        $(input).data('datepicker').setDate(null);
    });

    onInitCb();
};