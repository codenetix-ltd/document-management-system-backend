<div class="row">
    <div class="col-md-3">
        <form method="POST" action="{!! route('roles.assign_permission', $role->id) !!}">
            <div class="form-group">
                <label for="target-type" class="control-label">Permission:</label>
                @include('partials.select', [
                        'hideEmpty' => true,
                        'class' => 'form-control input-sm',
                        'name'=>'permission',
                        'options' => $permissions,
                        'multi'=> false,
                        'value' => '',
                        'idKey' => 'machine_name',
                        'id' => 'permission-select',
                        'columnName' => 'label'
                    ])
            </div>
            <div class="form-group level-wrapper">
                <label for="target-type" class="control-label">Level:</label>
                @include('partials.select', [
                    'hideEmpty' => true,
                    'class' => 'form-control input-sm',
                    'name'=>'level',
                    'options' => [],
                    'id' => 'level-select'
                ])
            </div>
            <button class="add-permission btn btn-success" type="submit">Add Permission</button>
        </form>
    </div>
</div>
