<?php

namespace App\Http\Requests;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class FilterRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function getFilter():array
    {
        return $this->query->all()['filter'] ?? [];
    }
}
