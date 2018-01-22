@foreach($permissionGroups as $group)
    <h4>{!! $group->label !!}</h4>
    <table class="table table-bordered table-permissions">
        <thead>
        <tr>
            <th style="width: 30%; white-space: nowrap;">Permission</th>
            <th style="width: 30%; white-space: nowrap;">Access type</th>
            <th class="qualifier">
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($group->permissions as $permission)
            <tr>
                <td>{!! $permission->label !!}</td>
                <td>
                    @include('partials.select', [
                        'hideEmpty' => true,
                        'class' => 'form-control input-sm',
                        'name'=>'access_type['.$permission->id.']',
                        'value' => $role->permissions()->find($permission->id) ? $role->permissions()->find($permission->id)->pivot->access_type : '',
                        'options' => $accessTypesByPermissionIds->get($permission->id)->map(function($item){
                            return ['id' => $item['machine_name'], 'name' => $item['label']];
                        })->toArray(),
                    ])
                </td>
                <td class="qualifier">
                    <div class="qualifier-wrapper">
                        <?php $c = 0; ?>
                        @foreach($group->qualifiers as $i => $qualifier)
                            @if($c > 0)
                                <span>AND HAS</span>
                            @endif
                            @if($c == 0)
                                <span>HAS</span>
                            @endif
                            @include('partials.select', [
                                'hideEmpty' => true,
                                'class' => 'form-control input-sm',
                                'name'=>'qualifier['.$permission->id.']['.$qualifier->id.']',
                                'value' => $role->permissions()->find($permission->id)->pivot->qualifiers()->find($qualifier->id) ? $role->permissions()->find($permission->id)->pivot->qualifiers()->find($qualifier->id)->pivot->access_type : '',
                                'options' => array_map(function($item){
                                    return ['id' => $item['machine_name'], 'name' => $item['label']];
                                }, config('permissions.groups.'.$group->name.'.qualifiers.'.$qualifier->name.'.access_types'))])
                            <?php $c++; ?>
                        @endforeach
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endforeach

