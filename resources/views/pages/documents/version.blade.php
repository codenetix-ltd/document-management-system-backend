<h2 class="page-header">
    General information
</h2>
<form id="document-export-form" method="POST" action="{!! route('documents.export', [$document->getId()]) !!}"
      class="form">
    <table class="table table-striped table-attributes">
        @if(!empty($exportMode))
            <thead>
            <tr>
                <th>
                    <input type="checkbox" name="check_all">
                </th>
                <th>Name</th>
                <th>Value</th>
            </tr>
            </thead>
        @endif
        <tbody>
        @foreach($document->getParameters() as $parameter)
            <tr>
                @if(!empty($exportMode))
                    <td class="export-checkbox">
                        <input type="checkbox" name="params[fields][{!! $parameter->getName() !!}]">
                    </td>
                @endif
                <td class="leaf-attribute-title-cell">{!! trans('base.document.'.$parameter->getName()) !!}</td>
                <td>
                    @include('partials.outputs.'.$parameter->getTypeName(), ['attribute' => $parameter])
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @if(!$document->getAttributes()->isEmpty())
        <h2 class="page-header">
            Attributes
        </h2>
        <div>
            <table class="table table-bordered table-attributes">
                <tbody>
                @foreach($document->getAttributes() as $attribute)
                    <tr>
                        @if(!empty($exportMode))
                            <td class="export-checkbox">
                                <input type="checkbox" name="params[attributes][{!! $attribute->getId() !!}]">
                            </td>
                        @endif
                        <td class="leaf-attribute-title-cell">
                            {!! $attribute->getName() !!}
                        </td>
                        <td>
                            @include('partials.outputs.'.strtolower($attribute->getTypeName()), ['attribute' => $attribute])
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if(isset($exportMode) && $exportMode)
        <div class="export-options form-horizontal">
            <h3 class="page-header">Export Options</h3>
            <div class="form-group">
                <label for="export-file-name" class="col-sm-1 control-label">Filename </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="export-file-name" name="fileName"
                           placeholder="Filename"
                           value="{!! str_replace(' ', '_', $document->getName() . '_' . $document->getDocumentVersionModel()->version_name)  !!}">
                </div>
            </div>
            <div class="form-group">
                <label for="export-format" class="col-sm-1 control-label">Format</label>
                <div class="col-sm-8">
                    <select name="format" class="form-control input-sm" id="export-format">
                        <option value="xlsx">Excel</option>
                        <option value="pdf">PDF</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-1 col-sm-8">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="publish"> Generate public link
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-1 col-sm-8">
                    <button type="submit" class="btn btn-success">Export</button>
                </div>
            </div>
            <div class="export-result">
                <div class="form-group">
                    <label for="export-format" class="col-sm-1 control-label">File</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" readonly="readonly" class="form-control input-file-link">
                            <span class="input-group-btn">
                            <button class="btn btn-success btn-copy-link">
                                <i class="fa fa-copy"></i>
                            </button>
                            <a class="btn btn-primary btn-file-download" target="_blank">
                                <i class="fa fa-download"></i> Download File
                            </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</form>

