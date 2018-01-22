$(document).on('ready', function () {
    $("#factoryId").select2();
    $("#labels").select2();
    $("[name=tags]").select2();
    $("#templateId").select2();

    $('[name=template_id]').on('change', function () {
        var documentVersionId = $(this).closest('form').data('document-version-id');
        attributesWithErrorNames = [];
        if (!this.value.length) {
            $('.attributes-wrapper').html('');
        } else {
            $('form .spinner').show();
            $.ajax({
                url: $(this).closest('form').data('attributes-url') + '/?template_id=' + this.value + (documentVersionId ? ('&document_version_id=' + documentVersionId) : ''),
            }).done(function (data) {
                $('form .spinner').hide();
                $('.attributes-wrapper').html(data);
                initAttributesListeners();
            });
        }
    });

    initAttributesListeners();

    var submitButton = $('.box-footer button');
    var attributesWithErrorNames = [];

    submitButton.on('click', function (e) {
        if (attributesWithErrorNames.length) {
            e.preventDefault();
            toastr["warning"]("To send a form you have to correct the validation errors");
        }
    });

    function initAttributesListeners() {
        $('.attributes-wrapper input[data-type=string]').attr('autocomplete', 'off');
        $('.attributes-wrapper input[data-type=string]').each(function(){
            var that = this;
            $(this).typeahead({
                source: function(query, process){
                    $.get($('.attributes-wrapper').data('autocomplete-url'), {query: query, attributeId: $(that).data('attribute-id')}, function (data) {
                        return process(JSON.parse(data));
                    });
                },
                fitToElement: true
            });
        });

        $('.attributes-wrapper input').each(function () {
            var showed = false;

            var message = '';
            var tooltip = $(this).tooltip({
                animation: false,
                html: true,
                placement: 'auto',
                title: function () {
                    return message;
                },
                trigger: 'manual',
                template: '<div class="tooltip red-tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
            });

            $(this).on('keyup change', function (e) {
                var that = this;
                if (isFloat($(this).val().replace(',', '.'))) {
                    $(this).val($(this).val().replace(',', '.'));
                }

                var rules = getValidationRulesByTypeName($(this).data('type'), $(this));
                var result = approve.value($(this).val(), rules);

                message = result.errors.join('</br>');
                if (!result.approved) {
                    //if (!showed) {
                    attributesWithErrorNames.indexOf($(this).attr('name')) === -1 && attributesWithErrorNames.push($(this).attr('name'));
                    showed = true;
                    $(this).tooltip('show');
                    //}
                } else {
                    showed = false;
                    var i = attributesWithErrorNames.indexOf($(this).attr('name'));
                    if (i > -1) {
                        attributesWithErrorNames.splice(i, 1);
                    }
                    $(this).tooltip('hide');
                }

                //TODO: move away
                if (e.originalEvent !== undefined) {
                    if ($(this).closest('.deviation-value-form-group').length) {
                        $(this).closest('.deviation-value-form-group').find('input').each(function () {
                            if (that != this) {
                                $(this).trigger('keyup');
                            }
                        });
                    }
                }
            });
        });
    };

    approve.addTest({
        message: '{title} must be integer or float value',
        validate: function (value, pars) {
            return isInt(value) || isFloat(value);
        }
    }, 'float_or_integer');

    var valueWithDeviatiosTest = {
        expects: [
            'firstValue',
            'secondValue',
            'firstValueTitle',
            'secondValueTitle'
        ],
        message: '{firstValueTitle} can not be greater than {secondValueTitle}',
        validate: function (value, pars) {
            if (isNumeric(pars.firstValue) && isNumeric(pars.secondValue)) {
                return parseFloat(pars.firstValue) <= parseFloat(pars.secondValue);
            }
            return true;
        }
    };
    approve.addTest(valueWithDeviatiosTest, 'value_with_deviations');

    function isNumeric(n) {
        return isInt(n) || isFloat(n);
    }

    function isInt(n) {
        return parseInt(n) == n && n % 1 === 0;
    }

    function isFloat(n) {
        return parseFloat(n) == n && n % 1 !== 0;
    }

    function getValidationRulesByTypeName(typeName, input) {
        switch (typeName) {
            case 'string':
                return {
                    ignoreNull: true,
                    max: 255,
                    title: 'String attribute'
                };
            case 'numeric':
                return {
                    ignoreNull: true,
                    float_or_integer: true,
                    title: 'Numeric attribute'
                };
            case 'value_with_deviations':
                var rules = {
                    ignoreNull: true,
                    float_or_integer: true,
                    stop: true,
                    title: 'Attribute with deviations'
                };
                switch (input.data('deviation-field-type')) {
                    case 'left':
                        rules.value_with_deviations = {
                            firstValue: $(input.closest('.deviation-value-form-group').find('input')[0]).val(),
                            secondValue: $(input.closest('.deviation-value-form-group').find('input')[1]).val(),
                            firstValueTitle: 'Left deviation',
                            secondValueTitle: 'Value'
                        };
                        break;
                    case 'value':
                        rules.value_with_deviations = {
                            firstValue: $(input.closest('.deviation-value-form-group').find('input')[1]).val(),
                            secondValue: $(input.closest('.deviation-value-form-group').find('input')[2]).val(),
                            firstValueTitle: 'Value',
                            secondValueTitle: 'Right deviation'
                        }
                        break;
                    case 'right':
                        rules.value_with_deviations = {
                            firstValue: $(input.closest('.deviation-value-form-group').find('input')[0]).val(),
                            secondValue: $(input.closest('.deviation-value-form-group').find('input')[2]).val(),
                            firstValueTitle: 'Left deviation',
                            secondValueTitle: 'Right deviation'
                        };
                        break;
                }
                return rules;
        }
    }

    $('.btn-view-version').on('click', function (e) {
        e.preventDefault();
        $('#documentVersionView .modal-body-content').html('');
        $('#documentVersionView .spinner').show();
        $('#documentVersionView').modal('show');
        $.ajax({
            url: $(this).data('url')
        }).done(function (data) {
            $('#documentVersionView .spinner').hide();
            $('#documentVersionView .modal-body-content').html(data);
        });
    });
});
