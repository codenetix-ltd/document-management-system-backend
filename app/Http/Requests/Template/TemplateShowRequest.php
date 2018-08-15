<?php

namespace App\Http\Requests\Template;

use App\Http\Requests\ABaseAPIRequest;
use App\Services\TemplateService;
use Illuminate\Database\Eloquent\Model;

class TemplateShowRequest extends ABaseAPIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return $this->getAuthorizer()->check('template_view');
    }

    /**
     * @param TemplateService $templateService
     * @return mixed
     */
    public function getTargetModel(TemplateService $templateService): Model
    {
        return $templateService->find($this->route()->parameter('template'));
    }
}
