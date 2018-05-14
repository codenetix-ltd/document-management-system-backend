<?php

namespace App\Http\Requests\Document;

use App\Services\System\EloquentTransformer;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class DocumentPatchRequest extends DocumentBaseRequest
{
    protected $modelConfigName = 'DocumentPatchRequest';

    public function transform(string $interface)
    {
        $data = $this->only(array_keys($this->rules()));
        $object = $this->container->make($interface);
        $transformer = $this->container->make(EloquentTransformer::class);
        $transformer->transform($data, $object);
        $this->updatedFields = $transformer->getTransformedFields();

        return $object;
    }
}
