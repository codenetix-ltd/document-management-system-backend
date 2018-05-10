<?php

namespace App\Http\Requests\Document;

use App\Http\Requests\BulkApiRequest;
use App\Services\System\EloquentTransformer;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class DocumentBulkPatchRequest extends BulkApiRequest
{
    protected $modelConfigName = 'DocumentPatchRequest';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function getTransformer()
    {
        return $this->container->make(EloquentTransformer::class);

    }


}
