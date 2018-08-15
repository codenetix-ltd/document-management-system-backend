<?php

namespace App\Http\Requests\Label;

use App\Http\Requests\ABaseAPIRequest;
use App\Services\LabelService;
use Illuminate\Database\Eloquent\Model;

class LabelShowRequest extends ABaseAPIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return $this->getAuthorizer()->check('label_view');
    }

    /**
     * @param LabelService $labelService
     * @return mixed
     */
    public function getTargetModel(LabelService $labelService): Model
    {
         return $labelService->find($this->route()->parameter('label'));
    }
}
