<?php

namespace App\Http\Requests\Template;

use App\QueryParams\EmptyQueryParamsObject;
use App\QueryParams\IQueryParamsObject;
use App\Http\Requests\ABaseAPIRequest;

/**
 * Created by Andrew Sparrow <andrew.sprw@gmail.com>
 */
class TemplateListRequest extends ABaseAPIRequest
{

    /**
     * @return boolean
     */
    public function authorize(): bool
    {
        //@TODO fix this shit
        return true;
    }

    /**
     * @return IQueryParamsObject
     */
    protected function createQueryParamsObject(): IQueryParamsObject
    {
        return EmptyQueryParamsObject::makeFromRequest($this);
    }
}
