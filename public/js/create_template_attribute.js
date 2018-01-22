$(document).on('ready', function () {
    $('[name=type_id]').on('change', function () {
        if (!this.value.length) {
            $('.type-form-wrapper').html('');
        } else {
            var attributeId = $(this).closest('form').data('attribute_id');
            $.ajax({
                url: $(this).closest('form').data('type-form-url') + '/?type_id=' + this.value + (attributeId ? ('&attribute_id=' + attributeId): '')
            }).done(function (data) {
                $('.type-form-wrapper').html(data);
            });
        }
    });
});