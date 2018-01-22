$(document).on('ready', function () {
    var documentVersionViewModal = $('#documentVersionView');
    var spinner = $('.spinner', documentVersionViewModal);
    var showExportDocumentModalBtn = $('#export-document');

    $('.btn-view-version').on('click', function (e) {
        e.preventDefault();
        $('.modal-body-content', documentVersionViewModal).html('');
        spinner.show();
        documentVersionViewModal.modal('show');

        $.ajax({
            url: $(this).data('url')
        }).done(function (data) {
            spinner.hide();
            $('.modal-body-content', documentVersionViewModal).html(data);
        });
    });

    showExportDocumentModalBtn.on('click', function (e) {
        e.preventDefault();
        $('.modal-body-content', documentVersionViewModal).html('');
        spinner.show();
        documentVersionViewModal.modal('show');

        $.ajax({
            url: $(this).data('url')
        }).done(function (data) {
            spinner.hide();

            var data = $('#documentVersionView .modal-body-content').html(data);
            var documentExportForm = $('form', data);

            initDocumentExportForm(documentExportForm);
        });
    });

    function initDocumentExportForm(documentExportForm){
        var exportResultContainer = $('.export-result', documentExportForm);
        exportResultContainer.hide();

        $('.export-checkbox input, [name=check_all]', documentExportForm).prop('checked', true);
        $('#export-format', documentExportForm).select2({
            minimumResultsForSearch: -1
        });

        $('[name=check_all]', documentExportForm).on('change', function(){
            $('.export-checkbox input', documentExportForm).prop('checked', $(this).prop('checked'));
        });

        $(documentExportForm).on('submit', function (e) {
            e.preventDefault();

            $('.export-button', documentExportForm).prop('disabled', true);
            spinner.show();
            exportResultContainer.hide();

            $.ajax({
                url: $(documentExportForm).attr('action'),
                type: 'POST',
                dataType: 'json',
                data: documentExportForm.serialize(),
                success: function (result) {
                    spinner.hide();

                    exportResultContainer.show();

                    var copyLinkBtn = exportResultContainer.find('.btn-copy-link');
                    if (result.publish) {
                        copyLinkBtn.closest('span').addClass('input-group-btn');
                        exportResultContainer.find('.input-file-link').val(result.fileUrl).show();
                        copyLinkBtn.show();
                    } else {
                        copyLinkBtn.closest('span').removeClass('input-group-btn');
                        exportResultContainer.find('.input-file-link').hide();
                        copyLinkBtn.hide();
                    }

                    exportResultContainer.find('.btn-file-download').attr('href', result.fileUrl);

                    exportResultContainer.show();
                    $('.export-button', documentExportForm).prop('disabled', false);
                    toastr["success"]('Document successfully exported');
                },
                fail: function (result) {
                    $('.export-button', documentExportForm).prop('disabled', false);
                }
            });
            return false;
        });

        $( '.export-result .btn-copy-link', documentExportForm).on('click', function (e) {
            e.preventDefault();
            var copyTextarea = $('.input-file-link', exportResultContainer);
            copyTextarea.select();
            document.execCommand('copy');
            toastr["success"]('Link copied');
        });
    }

});