<?php

namespace App\Http\Requests\Document;

use App\AttributeValue;
use App\Document;
use App\DocumentVersion;
use App\Http\Requests\ApiRequest;
use App\Services\System\EloquentTransformer;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class DocumentBaseRequest extends ApiRequest
{
    protected $modelConfigName = 'DocumentRequest';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function getEntity(): Document
    {
        return $this->transform(Document::class);
    }

    public function transform(string $interface)
    {
        $data = $this->only(array_keys($this->rules()));
        /** @var Document $object */
        $object = $this->container->make($interface);
        $transformer = $this->container->make(EloquentTransformer::class);
        $transformer->transform($data, $object);
        $this->updatedFields = $transformer->getTransformedFields();

        $actualVersion = $this->container->make(DocumentVersion::class);
        $actualVersion->setVersionName($data['actualVersion']['name']);
        $actualVersion->setLabelIds($data['actualVersion']['labelIds']);
        $transformer->transform($data['actualVersion'], $actualVersion);

        $attributeValues = [];

        foreach($data['actualVersion']['attributeValues'] as $attributeValue) {
            $attributeValue['attribute_id'] = $attributeValue['id'];
            unset($attributeValue['id']);
            $value = new AttributeValue();
            $attributeValues[] = $transformer->transform($attributeValue, $value);
        }

        $actualVersion->setAttributeValues($attributeValues);
        $object->setActualVersion($actualVersion);

        return $object;

    }


}
