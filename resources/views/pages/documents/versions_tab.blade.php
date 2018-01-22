<table class="table table-striped">
    <thead>
    <tr>
        <td>{!! trans('base.document.version_name') !!}</td>
        <td>{!! trans('base.common.comment') !!}</td>
        <td>{!! trans('base.common.created_at') !!}</td>
        <td>{!! trans('base.common.actions') !!}</td>
    </tr>
    </thead>
    <tbody>
    @foreach($document->getDocumentVersionModels() as $version)
        <tr>
            <td>{!! $version->version_name !!}</td>
            <td>{!! $version->comment !!}</td>
            <td>{!! $version->created_at !!}</td>
            <td>
                <a href="{!! route('document_versions.get', [$version->id]) !!}" class="btn btn btn-success btn-xs btn-view-version"
                   data-url="{!! route('document_versions.get', [$version->id]) !!}">
                    <i class="fa fa-eye"></i> {!! trans('base.document.view_version') !!}
                </a>
                @if(authorizeActionForDocument('document_delete', $document->getBaseModel()))
                    @include('partials.delete_button', ['url' => route('document_versions.delete', [$version->id]), 'confirmText' => 'Are you that you want to delete version '.$version->version_name.'?'])
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
