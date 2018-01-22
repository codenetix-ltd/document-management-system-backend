<?php

namespace App\Http\Controllers\API;

use App\CommandInvokers\TransactionCommandInvoker;
use App\Contracts\Commands\Role\IRoleGetCommand;
use App\Contracts\Services\IAssignPermissionToRoleService;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends APIController
{
}
