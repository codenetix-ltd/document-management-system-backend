<?php

namespace App\Http\Controllers;

use App\Entities\Document;
use App\Entities\User;
use App\Http\Requests\Dashboard\DashboardShowRequest;
use App\Services\FileService;
use App\Services\LogService;
use App\Services\UserService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DashboardsController extends Controller
{
    /**
     * @param DashboardShowRequest $request
     * @param string $typeId
     * @param UserService $userService
     * @param FileService $fileService
     * @param LogService $logService
     * @return array
     */
    public function show(DashboardShowRequest $request, string $typeId, UserService $userService, FileService $fileService, LogService $logService)
    {


        return array_only(array(
            'activeDocumentsTotal' => Document::whereNull('substitute_document_id')->count(),
            'activeUsersTotal' => User::count(),
            'uniqueVisitorsTodayTotal' => $userService->getUniqueVisitorsTodayTotal(),
            'diskSpaceUsedTotal' => $fileService->getDiskUsageTotal('document_attachments'),
            'activitiesChart' => collect(CarbonPeriod::since(Carbon::now()->subDays(6))->until(Carbon::now()))->map(function($date) use ($logService) {

                return [
                    'date' => $date->format('d-m-Y'),
                    'value' => $logService->getActionsTotal($date)
                ];
            })
        ), $request->queryParamsObject()->getIncludeData());
    }
}
