<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionGroupResource;
use App\Services\PermissionService;

class PermissionController extends Controller
{
    public function index(PermissionService $permissionService)
    {
        $permissionGroups = $permissionService->getPermissionGroups();

        return (PermissionGroupResource::collection($permissionGroups))->response()->setStatusCode(200);
    }

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
