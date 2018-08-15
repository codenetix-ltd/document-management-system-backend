<?php

namespace App\Http\Requests\Log;

use App\QueryParams\LogListQueryParamsObject;
use App\QueryParams\IQueryParamsObject;
use App\Http\Requests\ABaseAPIRequest;

/**
 * Created by Andrew Sparrow <andrew.sprw@gmail.com>
 */
class LogListRequest extends ABaseAPIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->getAuthorizer()->check('logs_view');
    }

    protected function createQueryParamsObject(): IQueryParamsObject
    {
        return LogListQueryParamsObject::makeFromRequest($this);
    }
}