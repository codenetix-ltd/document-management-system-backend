<?php

namespace App\Http\Controllers;

use App\Contracts\Services\IMorphMapService;
use App\DataTables\LogsDataTable;
use App\Helpers\Builders\AuthorizerFactory;

class LogsController extends Controller
{
    public function index(LogsDataTable $dataTable, IMorphMapService $service)
    {
        $authorizer = AuthorizerFactory::make('logs');
        $authorizer->authorize('logs_view');
        
        $references = $service->getList();

        return $dataTable->render('pages.logs.index', compact('references'));
    }
}
