<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\ABaseAPIRequest;
use App\QueryParams\EmptyQueryParamsObject;
use App\QueryParams\IQueryParamsObject;

class DashboardShowRequest extends ABaseAPIRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return IQueryParamsObject
     */
    protected function createQueryParamsObject(): IQueryParamsObject
    {
        return EmptyQueryParamsObject::makeFromRequest($this)
            ->setAllowedIncludes([
                'activeDocumentsTotal',
                'activeUsersTotal',
                'uniqueVisitorsTodayTotal',
                'diskSpaceUsedTotal',
                'activitiesChart'
            ]);
    }
}
