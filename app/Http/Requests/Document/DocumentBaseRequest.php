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
    protected $ignoredFields = [
        'createNewVersion'
    ];
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
        /** @var Document $object */
        $object = parent::transform($interface);

        $data = $this->only(array_keys($this->rules()));

        $actualVersion = $this->container->make(DocumentVersion::class);
        $actualVersion->setVersionName($data['actualVersion']['name']);
        $actualVersion->setLabelIds($data['actualVersion']['labelIds']);
        $actualVersion->setFileIds($data['actualVersion']['fileIds']);
        $transformer = $this->getTransformer();
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

    protected function getTransformer()
    {
        return $this->container->make(EloquentTransformer::class);
    }


}
