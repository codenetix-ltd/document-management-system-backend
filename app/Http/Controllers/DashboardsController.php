<?php

namespace App\Http\Controllers;

use App\Entities\Document;
use App\Entities\User;
use App\Http\Requests\Dashboard\DashboardShowRequest;

class DashboardsController extends Controller
{
    /**
     * @param DashboardShowRequest $request
     * @param string $typeId
     * @return array
     */
    public function show(DashboardShowRequest $request, string $typeId){
        return array_only([
            'activeDocumentsTotal' => Document::whereNull('substitute_document_id')->count(),
            'activeUsersTotal' => User::count(),
        ], $request->queryParamsObject()->getIncludeData());
    }
}
