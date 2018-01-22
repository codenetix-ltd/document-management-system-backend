@extends('layouts.index')

@section('content')
    @include('partials.content_header', [
    'title' => 'View document '.$document->getName(),
    'breadcrumbs' => [
        'Home' => 'home',
        'Documents' => 'documents.list',
        'View Document ' => ['documents.view', $document->getId()]
    ]])

    <!-- Main content -->
    <section class="content">
        @if ($document->isTrashed())
            <div class="row">
                <div class="col-md-12">
                    <div class="status-bar">
                        <span class="alert-warning btn-sm">This document is archived.</span>
                        @if($document->getBaseModel()->substitute_document_id)
                            &nbsp;&nbsp;Actual document is <a href="{!! route('documents.view', $document->getBaseModel()->substitute_document_id) !!}">{!! $document->getBaseModel()->substituteDocument->name !!}</a>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#edit" data-toggle="tab">{!! trans('base.common.content') !!}</a></li>
                        <li><a href="#versions" data-toggle="tab">{!! trans('base.document.versions') !!}</a></li>
                    </ul>
                    <div class="pull-right" style="margin-right: 20px; margin-top: 10px;">
                        <button id="export-document" class="btn btn-success btn-sm"
                                data-url="{!! route('document_versions.get', [$document->getDocumentVersionModel()->id]) !!}?exportMode=true">
                                <i class="fa fa-upload"></i><span style="margin-left: 5px">Export</span>
                        </button>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="edit">
                            @include('pages.documents.version')
                        </div>
                        <div class="tab-pane" id="versions">
                            @include('pages.documents.versions_tab')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('pages.documents.version_modal')
@endsection

@section('js')
    <script src="/plugins/select2/select2.min.js"></script>
    <script src="/js/document_view.js"></script>
@endsection


