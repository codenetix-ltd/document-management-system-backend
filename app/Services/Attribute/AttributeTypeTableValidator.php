<?php

namespace App\Services\Attribute;

use App\Contracts\Models\IAttribute;
use App\Contracts\Repositories\ITypeRepository;
use App\Contracts\Services\Attribute\IAttributeTypeTableValidator;
use App\Exceptions\InvalidAttributeTypeException;
use App\Exceptions\InvalidAttributeDataStructureException;

class AttributeTypeTableValidator implements IAttributeTypeTableValidator
{
    private $typeRepository;

    public function __construct(ITypeRepository $typeRepository)
    {
        $this->typeRepository = $typeRepository;
    }

    /**
     * @param IAttribute $attribute
     * @return bool
     * @throws InvalidAttributeDataStructureException
     */
    public function validate(IAttribute $attribute): bool
    {
        $data = $attribute->getData();

        if (!key_exists('headers', $data)) {
            throw new InvalidAttributeDataStructureException('Headers properties not found');
        }
        if (!is_array($data['headers']) || count($data['headers']) === 0) {
            throw new InvalidAttributeDataStructureException('Headers properties is empty');
        }
        if (!key_exists('rows', $data)) {
            throw new InvalidAttributeDataStructureException('Rows properties not found');
        }
        if (!is_array($data['rows']) || count($data['rows']) === 0) {
            throw new InvalidAttributeDataStructureException('Rows properties is empty');
        }

        $availableTypeIds = $this->typeRepository->getTypeIds();
        $totalColumns = count($data['headers']);
        array_walk($data['rows'], function ($item) use ($totalColumns, $availableTypeIds) {
            if (count($item['columns']) !== $totalColumns) {
                throw new InvalidAttributeDataStructureException('Bad data structure');
            }

            array_walk($item['columns'], function($item) use ($availableTypeIds) {
                if (!key_exists('typeId', $item) || !in_array($item['typeId'], $availableTypeIds)) {
                    throw new InvalidAttributeTypeException('Unsupported attribute type');
                }
            });
        });

        return true;
    }
}