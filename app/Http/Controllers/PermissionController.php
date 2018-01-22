<?php

namespace App\Http\Controllers;

class PermissionController extends Controller
{
    public function getTemplateByPermission($permission)
    {
        return view('pages.roles.partials.permission_targets.' . $permission);
    }
}
