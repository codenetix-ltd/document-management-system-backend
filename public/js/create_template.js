$(document).on('ready', function () {
    var attrTable = $('#attributesTable');
    $('tbody', attrTable).sortable({
        axis: "y",
        cursor: "move",
        helper: function (e, tr) {
            var $originals = tr.children();
            var $helper = tr.clone();
            $helper.children().each(function (index) {
                // Set helper cell sizes to match the original sizes
                $(this).width($originals.eq(index).width()+20);
            });
            return $helper;
        },
        'update': refreshOrdering
    });

    function refreshOrdering() {
        var order = 0;
        var orders = $('tbody tr:not(.empty-placeholder)', attrTable).map(function(){
            return {id: $(this).data('id'), order: order++};
        }).toArray();
        $('[name=orders]').val(JSON.stringify(orders));
    }

    refreshOrdering();
});