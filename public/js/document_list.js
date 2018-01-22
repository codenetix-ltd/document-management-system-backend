function initListPage(onInitCb) {
    function initSelectFilters() {

        var selectOptions = {
            enableFiltering: true,
            filterBehavior: 'both',
            enableCaseInsensitiveFiltering: true,
            enableFullValueFiltering: true,
            buttonClass: 'btn btn-sm btn-default btn-flat',
            numberDisplayed: 1
        };

        $("#filter-template-input").multiselect(selectOptions);
        $("#filter-label-input").multiselect(selectOptions);
        $('#filter-factory-input').multiselect(selectOptions);

        function fitSelects() {
            var buttons = $('.multiselect-native-select button.dropdown-toggle');
            buttons.each(function () {
                var paddingsWidth = $(this).outerWidth() - $(this).width();
                var formGroupWidth = $(this).closest('.form-group').width();
                var labelWidth = $(this).closest('.form-group').find('.input-group-addon').outerWidth();
                $(this).width(formGroupWidth - labelWidth - paddingsWidth);
            });
        }

        fitSelects();

        $('.multiselect-search').bind('input', function () {
            var _that = $(this),
                searchingText = $(this).val().toLowerCase();
            if (searchingText) {
                setTimeout(function () {
                    _that.parent().parent().parent()
                        .find('li')
                        .not('.multiselect-filter-hidden')
                        .not('.multiselect-filter')
                        .each(function () {
                            var text = $(this).find('label').text().trim();
                            if (text.slice(0, searchingText.length).toLowerCase().indexOf(searchingText) === -1) {
                                $(this).addClass('multiselect-filter-hidden').hide();
                            }
                        });
                }, 500);
            }
        });


        $(window).on('resize', fitSelects);
        $('body').on('DOMSubtreeModified', $.debounce(50, fitSelects));
    }

    initSelectFilters();

    var filterCreatedAt = $("#filter-created-at-input");
    $('#created-at-start, #created-at-end').datepicker({}).on('changeDate', function (e) {
        $(this).datepicker('hide');
        filterCreatedAt.val($('#created-at-start').val() + '|' + $('#created-at-end').val());
        filterCreatedAt.change();
    });

    var filterUpdatedAt = $("#filter-updated-at-input");
    $('#updated-at-start, #updated-at-end').datepicker({}).on('changeDate', function (e) {
        $(this).datepicker('hide');
        filterUpdatedAt.val($('#updated-at-start').val() + '|' + $('#updated-at-end').val());
        filterUpdatedAt.change();
    });

    $('.btn-clear-input').on('click', function () {
        var id = $(this).attr('data-clear');
        var input = $('#' + id);
        $(input).data('datepicker').setDate(null);
    });

    $('.btn-manage-filter').on('click', function (e) {
        e.preventDefault();
        $(".document-filters-wrapper").slideToggle("slow");
    });

    $('#mass-compare').on('click', function () {
        var that = this;
        var ids = $('#dataTableBuilder').data('selected-row-ids');
        if (ids && ids.length > 1) {
            window.location = "/compare?documentIds=" + ids.join(',');
        } else {
            toastr["warning"]($(that).data('documents-required'));
        }
    });

    function massArchive(ids, element) {
        var successMsg = $(element).data('success-msg');
        var content = $('#archive-confirmation-body-template').html();
        $.confirm({
            title: $(element).data('confirm-title-text'),
            content: content,
            animation: 'none',
            columnClass: 'medium',
            onContentReady: function () {
                this.$content.find('[name=document_id]').select2({
                    placeholder: $(element).data('find-document-placeholder'),
                    ajax: {
                        url: $(element).data('document-list-url'),
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                query: params.term,
                                exceptIds: ids.join(','),
                                withArchived: false
                            };
                        },
                        processResults: function (data, params) {
                            return {
                                results: $.map(data, function (v) {
                                    return {id: v.id, text: v.name};
                                }),
                                pagination: {
                                    more: false
                                }
                            };
                        },
                        cache: true
                    },
                    minimumInputLength: 1
                });
            },
            buttons: {
                confirm: {
                    text: $(this).data('confirm-button-confirm-text'),
                    action: function (e) {
                        var documentId = this.$content.find('[name=document_id]').val();
                        if (!documentId || !documentId.length) {
                            toastr["warning"]($(element).data('document-required'));
                            return false;
                        }
                        $.post($(element).data('url'), {ids: ids, documentId: documentId})
                            .done(function (data) {
                                $('#dataTableBuilder').data('selected-row-ids', []);
                                $('#dataTableBuilder').DataTable().draw();
                                $.confirm({
                                    title: "Success",
                                    content: data.total + ' ' + successMsg,
                                    animation: "none",
                                    buttons: {
                                        confirm: {
                                            text: "Done",
                                            btnClass: "btn-blue"
                                        }
                                    }
                                });
                            });
                    },
                    btnClass: 'btn-blue'
                },
                cancel: {
                    text: $(element).data('confirm-button-cancel-text')
                }
            }
        });
    }

    $('#mass-archive').on('click', function (e) {
        e.preventDefault();
        var ids = $('#dataTableBuilder').data('selected-row-ids');
        if (ids && ids.length) {
            massArchive(ids, this);
        }
    });

    $('#dataTableBuilder').on('click', '.archive-document', function (e) {
        e.preventDefault();
        var ids = [];
        ids.push($(this).data('id'));
        massArchive(ids, this);
    });

    $('#mass-delete').on('click', function (e) {
        var ids = $('#dataTableBuilder').data('selected-row-ids');
        if (ids && ids.length) {
            e.preventDefault();
            var that = this;
            var successMsg = $(this).data('success-msg');
            $.confirm({
                title: $(this).data('confirm-title-text'),
                content: $(this).data('confirm-content-text'),
                animation: 'none',
                buttons: {
                    confirm: {
                        text: $(this).data('confirm-button-confirm-text'),
                        action: function () {
                            $.post($(that).data('url'), {ids: ids})
                                .done(function (data) {
                                    $('#dataTableBuilder').data('selected-row-ids', []);
                                    $('#dataTableBuilder').DataTable().draw();
                                    $.confirm({
                                        title: "Success",
                                        content: data.total + ' ' + successMsg,
                                        animation: "none",
                                        buttons: {
                                            confirm: {
                                                text: "Done",
                                                btnClass: "btn-blue"
                                            }
                                        }
                                    });
                                });
                        },
                        btnClass: 'btn-blue'
                    },
                    cancel: {
                        text: $(this).data('confirm-button-cancel-text')
                    }
                }
            });
        }
    });
    function reDrawTable() {
        var table = $($.fn.dataTable.tables(true));
        table.css('width', '100%');
        table.DataTable().columns.adjust().draw();
    }

    $(window).on('resize', $.debounce(500, function () {
        reDrawTable();
    }));

    $('.navbar-static-top a.sidebar-toggle').click(function () {
        setTimeout(reDrawTable, 500);
    });


    function initLoadFilters() {
        var filterFieldMap = {
            id: {
                inputName: "filter-id-input",
                type: "input"
            },
            name: {
                inputName: "filter-name-input",
                type: "input"
            },
            owner: {
                inputName: "filter-owner-input",
                type: "input"
            },
            template: {
                inputName: "filter-template-input",
                type: "select"
            },
            factory: {
                inputName: "filter-factory-input",
                type: "select"
            },
            label: {
                inputName: "filter-label-input",
                type: "select"
            },
            cas: {
                inputName: "created-at-start",
                type: "date"
            },
            cae: {
                inputName: "created-at-end",
                type: "date"
            },
            uas: {
                inputName: "updated-at-start",
                type: "date"
            },
            uae: {
                inputName: "updated-at-end",
                type: "date"
            },
            deleted_at: {
                inputName: "filter-deleted-at-input",
                type: "checkbox"
            },
            dataTable: {
                inputName: "",
                type: "table"
            }
        };

        function getQueryVariable() {
            var querystring = window.location.search.substring(window.location.search.indexOf('?') + 1).split('&');
            var params = {}, pair, d = decodeURIComponent;

            for (var i = querystring.length - 1; i >= 0; i--) {
                pair = querystring[i].split('=');
                params[d(pair[0])] = d(pair[1] || '');
            }

            return window.location.search ? params : {};
        }

        function getParamName(id) {
            var inputName = null;
            for (var param in filterFieldMap) {
                if (id === filterFieldMap[param]['inputName']) {
                    inputName = param;
                }
            }
            return inputName;
        }

        function setState(param, val) {
            var state = getQueryVariable(window.location.search);
            if (val) {
                state[param] = val instanceof Array ? val.join(",") : val;

            } else {
                delete state[param];
            }
            history.pushState({}, null, '/documents/list?' + $.param(state));
        }

        if (window.location.search) {
            var uriParams = getQueryVariable();
            for (var param in uriParams) {
                (function (param, uriParams, filterFieldMap) {
                    setTimeout(function () {
                        var input = $('#' + filterFieldMap[param]['inputName']);
                        switch (filterFieldMap[param]['type']) {
                            case "date":
                                input
                                    .data('datepicker')
                                    .setDate(uriParams[param]);
                                break;
                            case "select":
                                input
                                    .val(uriParams[param].split(','))
                                    .multiselect("refresh")
                                    .trigger($.Event("change"));
                                break;
                            case "table":
                                var table = $($.fn.dataTable.tables(true)),
                                    ids = uriParams[param].split(',');
                                $(table[0].rows).each(function () {
                                    var id = $($(this).find('td')[1]).text();
                                    if (ids.filter(function (val) {
                                            return val === id;
                                        }).length > 0) {
                                        $(this).addClass('selected');
                                    }
                                });
                                table.data('selected-row-ids', ids);
                                break;
                            default:
                                input
                                    .val(uriParams[param])
                                    .trigger($.Event("keyup", {keyCode: 13}));
                        }
                    }, 500);

                })(param, uriParams, filterFieldMap);
            }
        }

        $('.document-filters .form-group input').on('change', function (e) {
            if ($(this).attr("id") === undefined) {
                var inputGroup = $(this).closest('.input-group'),
                    selectedItems = [];
                inputGroup.find('li.active input').each(function () {
                    selectedItems.push($(this).val());
                });
                setState(getParamName(inputGroup.find('select').attr("id")), selectedItems);
            }
            else {
                setState(getParamName($(this).attr("id")), $(this).val())
            }
        });

        var table = $($.fn.dataTable.tables(true));
        table.on('click', function () {
            setTimeout(function () {
                var ids = [];
                $(table[0].rows).each(function () {
                    if ($(this).hasClass('selected')) {
                        ids.push(+$(this).find('.archive-document').attr('data-id'));
                    }
                });
                if (ids.length > 0) {
                    setState('dataTable', ids);
                }

            }, 500);
        });

    }

    var isInitFilters = false;
    $('#dataTableBuilder').on('draw.dt', function () {
        if (!isInitFilters) {
            initLoadFilters();
            isInitFilters = !isInitFilters;
        }
    });


    onInitCb();
};