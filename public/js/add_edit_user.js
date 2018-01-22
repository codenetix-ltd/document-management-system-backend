$(document).on('ready', function () {

    $("[name^=template_id]").select2();
    $("[name^=factory_id]").select2();

    $('#roles').select2({
        multiple: true
    });
});