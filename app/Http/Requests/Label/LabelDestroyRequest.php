<?php

namespace App\Http\Requests\Label;

use App\Http\Requests\ABaseAPIRequest;
use App\Services\LabelService;

class LabelDestroyRequest extends ABaseAPIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->getAuthorizer()->check('label_delete');
    }

    /**
     * @param LabelService $labelService
     * @return mixed
     */
    public function getTargetModel(LabelService $labelService)
    {
        return $labelService->find($this->route()->parameter('label'));
    }
}
