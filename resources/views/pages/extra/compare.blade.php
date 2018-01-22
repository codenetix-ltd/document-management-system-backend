@extends('layouts.index')

@section('content')
@include('partials.content_header', ['title' => 'Document comparison',
'breadcrumbs' => [
    'Home' => 'home',
    'Document list' => 'documents.list',
    'Documents comparison' => 'documents.compare'
]])
        <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-default">
                {{--<div class="box-header">--}}
                {{--<h1 class="box-title">Documents comparing</h1>--}}
                {{--</div>--}}
                <div class="box-body">
                    <ul class="nav nav-pills">
                        @foreach($documentGroups as $documentGroup)
                            <li role="presentation"
                                @if($documentCompareStructure->getDocuments()->first()->getTemplateModel()->id == $documentGroup->getTemplate()->id) class="active" @endif>
                                <a href="{!! route('documents.compare', ['onlyDifferences' => $onlyDifferences, 'templateId' => $documentGroup->getTemplate()->id, 'documentIds' => $originalDocumentIdsParam]) !!}">{!! $documentGroup->getTemplate()->name !!}
                                    ({!! $documentGroup->getDocumentsTotal() !!})</a>
                            </li>
                        @endforeach
                    </ul>
                    <p class="compare-actions">
                            <span class="compare-show-style">Show only:
                                <span class="compare-show-style-item">
                                    @if(!$onlyDifferences)
                                        all characteristics
                                    @else
                                        <a href="{!! route('documents.compare', ['onlyDifferences' => 0, 'templateId' => $originalTemplateIdParam, 'documentIds' => $originalDocumentIdsParam]) !!}">all characteristics</a>
                                    @endif
                                    </span>
                                |
                                    <span class="compare-show-style-item">
                                    @if($onlyDifferences)
                                            differences
                                        @else
                                            <a href="{!! route('documents.compare', ['onlyDifferences' => 1, 'templateId' => $originalTemplateIdParam, 'documentIds' => $originalDocumentIdsParam]) !!}">differences</a>
                                        @endif
                                    </span>
                            </span>
                    </p>
                </div>
            </div>
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">
                            @include('partials.message')
                            <div class="table-compare-wrapper table-responsive">
                                <div class="scroll-left"></div>
                                <table class="table table-bordered table-attributes table-compare responsive-table">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        @foreach($documentCompareStructure->getDocuments() as $document)
                                            <th class="table-compare-header-cell">
                                                <h2>
                                                    <a href="{!! route('documents.view', $document->getId()) !!}">
                                                        {!! $document->getName() !!}
                                                    </a>
                                                </h2>
                                                <span>
                                                    {!! $document->getFactoryModels()->pluck('name')->implode(',') !!}
                                                    | {!! $document->getUserModel()->full_name !!}
                                                </span>
                                                <div class="document-operations">
                                                    <a href="{!! route('documents.edit', ['id' => $document->getId()]) !!}" target="_blank">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                    <a class="document-remove" data-less-than-required-text="Document number less than 3. Impossible to perform the action." data-disabled="{!! $documentCompareStructure->getDocuments()->count() <= 2 ? 'true' : 'false'!!}" data-confirm-title-text="Confirmation" data-confirm-content-text="Are you sure that you want to remove {!! $document->getName() !!} from comparing?" data-url="{!! route('documents.compare', ['onlyDifferences' => 1, 'templateId' => $originalTemplateIdParam, 'documentIds' => $documentCompareStructure->getDocuments()->map(function($item){ return $item->getId(); })->diff([$document->getId()])->implode(',')]) !!}" href="#">
                                                        <i class="fa fa-times-circle-o"></i>
                                                    </a>
                                                </div>
                                            </th>
                                        @endforeach
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($documentCompareStructure->getRows() as $row)
                                        @include('partials.outputs.table_compare_output_rows.'.$row->getTypeName(), ['row' => $row, 'documentCompareStructure' => $documentCompareStructure])
                                    @empty
                                        <td class="text-center" colspan="{!! $documentCompareStructure->getDocuments()->count()+1 !!}">
                                            No data
                                        </td>
                                    @endforelse
                                    </tbody>
                                </table>
                                <div class="scroll-right"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</section>
<!-- /.content -->
@endsection

@push('css')
<link rel="stylesheet" href="/plugins/fixedheader/fixedheader.min.css">
@endpush

@push('js')
<script src="/plugins/select2/select2.min.js"></script>
<script src="/plugins/dragscroll/jquery.dragscroll.js"></script>
<script type="application/javascript">
    $('.document-filters select').select2({
        width: 100
    });
</script>
<script src="/js/document_compare.js"></script>
@endpush