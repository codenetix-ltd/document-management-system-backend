$(document).on('ready', function () {


    // function collectData() {
    //     return {
    //         'permission': $('#permission').val(),
    //         'target': $('#target select').val()
    //     };
    // }
    //
    // function initDetachPermissionsEvents() {

    // }

    function confirmDetach(elem) {
        $.confirm({
            title: $(elem).data('confirm-title-text'),
            content: $(elem).data('confirm-content-text'),
            animation: 'none',
            buttons: {
                confirm: {
                    text: $(elem).data('confirm-button-confirm-text'),
                    action: function () {
                        window.location = $(elem).data('url');
                    },
                    btnClass: 'btn-blue'
                },
                cancel: {
                    text: $(elem).data('confirm-button-cancel-text')
                }
            }
        });
    }

    //
    // function updatePermissionsList(roleId) {
    //     $.get('/roles/' + roleId + '/permissions')
    //         .done(function (html) {
    //             $('#permission-list-wrapper').html(html);
    //             initDetachPermissionsEvents();
    //         });
    // }

    // var permissionForm = $('#permission-form');
    // permissionForm.on('submit', function (e) {
    //     e.preventDefault();
    //
    //     var data = collectData();
    //     $.ajax({
    //         url: $(permissionForm).attr('action'),
    //         type: 'POST',
    //         dataType: 'json',
    //         data: data,
    //         success: function (result) {
    //             toastr["success"]('Permission successfully added');
    //             updatePermissionsList($(permissionForm).data('role-id'));
    //             step1();
    //         },
    //         fail: function (result) {
    //
    //         }
    //     });
    //     return false;
    // });

    var permissionSelect = $("#permission-select").select2({
        minimumResultsForSearch: -1
    }).on('change', function (e) {
        $.get('/api/permissions/' + $(this).val() + '/level-form').done(function (data) {
            $('.level-wrapper').hide();
            if(!data.length){
                return;
            }
            $('.level-wrapper').show();
            $("#level-select").select2('destroy');
            $("#level-select").select2({
                minimumResultsForSearch: -1,
                data: $.map(data, function(v){
                    return {id: v.id, text: v.name};
                })
            });
        });
    });
    $('.level-wrapper').hide();

    $("[name^=access_type]").on('change', function(val){
        if($(this).val() == 'by_qualifiers'){
            $(this).closest('tr').find('.qualifier-wrapper').show();
        } else {
            $(this).closest('tr').find('.qualifier-wrapper').hide();
        }
    });

    $('[name^=access_type]').trigger('change');


    $("[name^=template_id]").select2();
    $("[name^=factory_id]").select2();
    $("[name^=level]").select2().on('change', function (e) {
        console.log($(this).val());
        if($(this).val().includes('any') && $(this).val().length > 1){
            $(this).val(['any']).trigger('change');
        } else if($(this).val().includes('any') && $(this).val().length == 1) {
            $(this).val([]);
        }
    });

    $('.detach-permission').on('click', function (e) {
        e.preventDefault();
        confirmDetach($(this));
    });
});