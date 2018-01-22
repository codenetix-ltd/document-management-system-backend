@extends('layouts.index')

@section('content')
    @include('partials.add_edit_header', [
        'modelName' => 'model',
        'nameField' => 'name',
        'entityName' => 'Document',
        'routePrefix' => 'documents'
    ])

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#edit" data-toggle="tab">{!! trans('base.common.content') !!}</a>
                        </li>
                        @isset($document)
                        <li><a href="#versions" data-toggle="tab">{!! trans('base.document.versions') !!}</a></li>
                        @endisset
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="edit">
                            <!-- /.box-header -->
                        @include('partials.message')
                        @include('partials.errors')
                        <!-- form start -->
                            <form class="form-horizontal"
                                  action="{!! isset($document) ? route('documents.update', [$document->getId()]) :route('documents.store') !!}"
                                  method="POST" enctype="multipart/form-data"
                                  data-attributes-url="{!! route('attributes.list')!!}"
                                  @isset($document)
                                  data-document-version-id="{!! $document->getDocumentVersionModel()->id !!}"
                                    @endisset
                            >
                                {{ csrf_field() }}
                                <div class="box-header">
                                    <h3 class="box-title">General information</h3>
                                </div>
                                <div class="box-body">
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label for="name"
                                               class="col-sm-2 control-label">{!! trans('base.common.name') !!}</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="name" class="form-control" id="name"
                                                   placeholder="{!! trans('base.document.document_name') !!}"
                                                   value="{{ old('name', isset($document) ? $document->getName() : null) }}">
                                        </div>
                                    </div>
                                    @isset($document)
                                    <div class="form-group">
                                        <label for="actualVersion"
                                               class="col-sm-2 control-label">{!! trans('base.document.actual_version') !!}</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="actualVersion"
                                                   placeholder="{!! trans('base.document.actual_version') !!}"
                                                   value="{{$document->getDocumentVersionModel()->version_name }}" disabled>
                                        </div>
                                    </div>
                                    @endisset
                                    <div class="form-group{!! $errors->has('template_id') ? ' has-error' : '' !!}">
                                        <label for="templateId"
                                               class="col-sm-2 control-label">{!! trans('base.common.template') !!}</label>
                                        <div class="col-sm-6">
                                            @include('partials.select', [
                                                'class' => 'form-control',
                                                'name'=>'template_id',
                                                'id' => 'templateId',
                                                'options' => $templates,
                                                'value' =>  old('template_id',isset($document) ? $document->getTemplateModel()->id : null)
                                            ])
                                        </div>
                                    </div>
                                    <div class="form-group{!! $errors->has('comment') ? ' has-error' : '' !!}">
                                        <label for="comment"
                                               class="col-sm-2 control-label">{!! trans('base.common.comment') !!}</label>
                                        <div class="col-sm-6">
                                        <textarea name="comment" class="form-control" id="comment"
                                                  placeholder="{!! trans('base.document.document_comment') !!}">{{ old('comment',isset($document) ? $document->getDocumentVersionModel()->comment : null) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group{!! $errors->has('labels') ? ' has-error' : '' !!}">
                                        <label for="labels"
                                               class="col-sm-2 control-label">{!! trans('base.common.labels') !!}</label>
                                        <div class="col-sm-6">
                                            @include('partials.select', ['hideEmpty' => true, 'class' => 'form-control', 'name'=>'labels[]', 'id' => 'labels', 'options' => $labels, 'multi'=> true, 'value' => old('labels',  isset($document) ? $document->getLabelModels()->pluck('id')->toArray() : []) ])
                                        </div>
                                    </div>
                                    <div class="form-group{!! $errors->has('factoryId') ? ' has-error' : '' !!}">
                                        <label for="factoryId"
                                               class="col-sm-2 control-label">{!! trans('base.common.factory') !!}</label>
                                        <div class="col-sm-6">
                                            @include('partials.select', ['hideEmpty' => true, 'class' => 'form-control', 'name'=>'factory_id[]', 'id' => 'factoryId', 'options' => $factories, 'multi'=> true, 'value' => old('factory_id',  isset($document) ? $document->getFactoryModels()->pluck('id')->toArray() : '') ])
                                        </div>
                                    </div>
                                    <div class="form-group{!! $errors->has('owner') ? ' has-error' : '' !!}">
                                        <label for="ownerId"
                                               class="col-sm-2 control-label">{!! trans('base.common.owner') !!}</label>
                                        <div class="col-sm-6">
                                            @include('partials.select', [
                                                'class' => 'form-control',
                                                 'name'=>'owner_id',
                                                 'id' => 'ownerId',
                                                 'options' => $users,
                                                 'disabled' => Auth::user()->hasAnyPermission('administration') ? false : true,
                                                 'value' => old('owner_id',  isset($document) ? $document->getUserModel()->id : Auth::user()->id)
                                                 ]
                                             )
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="file"
                                               class="col-sm-2 control-label">{!! trans('base.common.files') !!}</label>
                                        <div class="col-sm-8">
                                            @include('partials.fileupload.form', ['name' => 'files[]', 'id' => 'files', 'initialURL' => isset($document) ? route('document_files.list', [$document->getId()]) : null, 'uploadURL' => route('document_attachments.store')])
                                        </div>
                                    </div>
                                    @include('partials.spinner')
                                    <div class="attributes-wrapper" data-autocomplete-url="{!! route('api.attribute_values.values') !!}">
                                        @isset($attributes)
                                        @include('partials.attributes', ['attributes' => $attributes])
                                        @endisset
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer form-inline">
                                        @if(isset($document) && authorizeActionForDocument('document_update', $document->getBaseModel()))
                                            <button type="submit" class="btn btn-success" style="margin-right: 15px;">
                                                Update
                                            </button>
                                            <div class="checkbox">
                                                <label>
                                                    <input name="increase_version" type="checkbox" id="increaseVersion"
                                                           value="1" {!! old('increase_version', true) ? " checked" : "" !!}/>
                                                    {!! trans('base.document.increase_version') !!}
                                                </label>
                                            </div>
                                        @elseif(!isset($document))
                                            <button type="submit"
                                                    class="btn btn-success">{!! trans('base.common.create') !!}</button>
                                        @endif
                                    </div>
                                    <!-- /.box-footer -->

                                </div>
                            </form>
                        </div>
                        @isset($document)
                        <div class="tab-pane" id="versions">
                            <!-- /.box-header -->
                            @include('partials.message')
                            @include('partials.errors')
                            @include('pages.documents.versions_tab')
                        </div>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

    @include('pages.documents.version_modal')
@endsection

@push('js')
    <script src="/plugins/approvejs/approve.min.js"></script>
    <script src="/plugins/select2/select2.min.js"></script>
    <script src="/js/create_document.js"></script>
@endpush