<?php

namespace App\Http\Controllers\API;


class PermissionController extends APIController
{
    public function getLevels($permissionId){
        $levels = config('permissions.groups.document.permissions.'.$permissionId.'.qualifiers');

        if(empty($levels)){
            return [];
        }

        $formattedLevels = [];
        foreach ($levels as $id => $level){
            $formattedLevels[] = [
                'id' => $id,
                'name' => $level['label']
            ];
        }

        return $formattedLevels;
    }
}
