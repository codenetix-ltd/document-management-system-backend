/*
 * jQuery File Upload Plugin JS Example
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * https://opensource.org/licenses/MIT
 */

/* global $, window */

$(document).ready(function () {
    'use strict';

    var context = $('#files');
    var files = $('[name=files]', context);
    var uploadURL = context.data('upload-url');
    var initialURL = context.data('initial-url');


    context.fileupload({
        url: uploadURL
    });


    var fileIds = [];
    context.bind('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (i, file) {
            if (fileIds.indexOf(file.id) === -1)
                fileIds.push(file.id);
        });
        files.val(JSON.stringify(fileIds));
    });

    context.bind('fileuploaddestroyed', function (e, data) {
        var id = /^(?:.+)\/([0-9]+)$/.exec(data.url)[1];
        var index = fileIds.indexOf(parseInt(id));
        if (index != -1) {
            fileIds.splice(index, 1);
        }
        files.val(JSON.stringify(fileIds));
    });

    // Load existing files:
    if (initialURL.length) {
        context.addClass('fileupload-processing');
        $.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: initialURL,
            dataType: 'json',
            context: context[0]
        }).always(function () {
            $(this).removeClass('fileupload-processing');
        }).done(function (result) {
            $(this).fileupload('option', 'done')
                .call(this, $.Event('fileuploaddone'), {result: result});

            $.each(result.files, function (i, file) {
                if (fileIds.indexOf(file.id) === -1)
                    fileIds.push(file.id);
            });
            files.val(JSON.stringify(fileIds));
        });
    }

    function initEvent(elem) {
        $(elem).click(function () {
            setTimeout(function () {
                if ($('.files tr').length === 0) {
                    hideButtons();
                }
            }, 500)
        });
    }
    function initCancelEvent() {
        initEvent('.cancel');
        initEvent('.delete');
    }

    function hideButtons(){
        $('.start').hide();
        $('.cancel').hide();
        $('.delete').hide();
        $('.toggle').hide();
    }

    hideButtons();
    initCancelEvent();

    context.bind('fileuploadalways', function (e, data) {
        setTimeout(initCancelEvent, 1000);
    });
    context.bind('fileuploadchange', function (e, data) {
        setTimeout(initCancelEvent, 1000);

        if (data.files.length) {
            $('.start').show();
            $('.cancel').show();
            $('.delete').show();
            $('.toggle').show();
        }
    });

});

