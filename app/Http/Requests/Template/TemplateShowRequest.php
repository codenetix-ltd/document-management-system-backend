<?php

namespace App\Http\Requests\Template;

use App\Http\Requests\ABaseAPIRequest;
use App\Services\TemplateService;

class TemplateShowRequest extends ABaseAPIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->getAuthorizer()->check('template_view');
    }

    /**
     * @param TemplateService $templateService
     * @return mixed
     */
    public function getTargetModel(TemplateService $templateService)
    {
        return $templateService->find($this->route()->parameter('template'));
    }
}
