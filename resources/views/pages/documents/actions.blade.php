@if(authorizeActionForDocument('document_view', $document))
    <a class="btn btn-primary btn-xs" href="/documents/view/{{ $id }}"><i class="fa fa-eye"></i></a>
@endif

@if(!$document->trashed())
    @if(authorizeActionForDocument('document_update', $document))
        <a class="btn btn-success btn-xs" href="/documents/{{ $id }}"><i class="fa fa-edit"></i></a>
    @endif

    @if(authorizeActionForDocument('document_archive', $document))
        <button
                class="btn btn btn-warning btn-xs archive-document"
                data-id="{!! $id !!}"
                data-confirm-content-text="Do you really want to archive document {!! $document->name !!}?"
                data-url="{!! route('api.documents.mass_archive') !!}"
                data-confirm-title-text="Confirmation"
                data-success-msg="document has been archived"
                data-document-list-url="{!! route('api.documents.list') !!}"
                data-document-required="New actual document selection is required!"
                data-find-document-placeholder="Choose document">
            <i class="fa fa-book"></i>
        </button>
    @endif

    @if(authorizeActionForDocument('document_delete', $document))
        <button
                class="btn btn btn-danger btn-xs btn-delete"
                data-url="/documents/{{ $id }}/delete"
                data-confirm-content-text="Do you really want to delete document {{ $name }} ?"
                data-confirm-title-text="Confirmation"
                data-confirm-button-confirm-text="Delete"
                data-confirm-button-cancel-text="Cancel">
            <i class="fa fa-trash"></i>
        </button>
    @endif
@endif