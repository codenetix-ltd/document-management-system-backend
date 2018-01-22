$(document).on('ready', function () {
    $(document).on('click', '.btn-delete, .btn-confirm', function (e) {
        e.preventDefault();
        confirmWrapper(this);
    });

    if(window.location.hash.length){
        $('[href="'+window.location.hash+'"]').trigger('click');
    }

    $('.form-group .form-control').on('focus', function(){
        $(this).closest('.form-group').removeClass('has-error');
    });

    $('.tide-message').delay(100).slideDown(400).delay(6000).slideUp(400);
});


window.confirmWrapper = function(elem){
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