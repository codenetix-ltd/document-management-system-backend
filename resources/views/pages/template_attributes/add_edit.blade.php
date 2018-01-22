@extends('layouts.index')

@section('content')
    @include('partials.content_header', [
    'title' => isset($attribute) ? 'Edit '.$attribute->name : 'Template attribute create',
    'breadcrumbs' => [
        'Home' => 'home',
        'Templates' => 'templates.list',
        'Edit '.$template->name => ['templates.edit', $template->id],
        isset($attribute) ? 'Edit '.$attribute->name : 'Template attribute create' => isset($attribute) ? ['template_attributes.edit', $template->id, $attribute->id] : ['template_attributes.create', $template->id]
    ]])
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Template attribute</h3>
                    </div>
                    <!-- /.box-header -->
                @include('partials.message')
                @include('partials.errors')
                <!-- form start -->
                    <form class="form-horizontal" method="POST"
                          data-type-form-url="{!! route('partials_type_form.get') !!}"
                          @isset($attribute)
                          data-attribute_id="{!! $attribute->id !!}"
                          @endisset
                          action="{!! isset($attribute) ? route('template_attributes.update', ['templateId' => $template->id, 'id' => $attribute->id]) : route('template_attributes.store', ['templateId' => $template->id]) !!}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="form-group{!! $errors->has('name') ? ' has-error' : '' !!}">
                                <label for="name" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-6">
                                    <input type="text" name="name" class="form-control" id="name"
                                           placeholder="Attribute name"
                                           value="{!! old('name', isset($attribute) ? $attribute->name : null) !!}">
                                </div>
                            </div>
                            <div class="form-group{!! $errors->has('type_id') ? ' has-error' : '' !!}">
                                <label for="typeId" class="col-sm-2 control-label">Type</label>
                                <div class="col-sm-6">
                                    @include('partials.select', ['class' => 'form-control', 'name'=>'type_id', 'id' => 'typeId', 'options' => $types, 'value' =>  old('type_id',isset($attribute) ? $attribute->type_id : null)])
                                </div>
                            </div>
                            <div class="type-form-wrapper">
                                @isset($typeSpecifiedForm)
                                {!! $typeSpecifiedForm !!}
                                @endisset
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-success">
                                @if(isset($attribute))
                                    Update
                                @else
                                    Create
                                @endif
                            </button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.modal-dialog -->
    </div>
@endsection

@push('js')
<script src="/js/create_template_attribute.js" type="application/javascript"></script>
@endpush