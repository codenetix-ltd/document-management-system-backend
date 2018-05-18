<?php

namespace Tests\Feature;

use App\Attribute;
use App\Contracts\Repositories\ITypeRepository;
use App\Services\Type\TypeService;
use App\Template;
use Tests\ApiTestCase;

class AttributeTestasd extends ApiTestCase
{
    public function testCreateAttributeTypeTableSuccess()
    {
        $attribute = factory(Attribute::class)->states('table')->make();
        $template = factory(Template::class)->create();

        $typeTable = $this->typeRepository->getTypeByMachineName(TypeService::TYPE_TABLE);

        $response = $this->jsonRequestPostEntityWithSuccess('templates/' . $template->id . '/attributes', [
            'name' => $attribute->name,
            'typeId' => $typeTable->id,
            'data' => $attribute->data
        ]);

        //TODO documentation doesn't have commented fields
        $response->assertJson([
            'name' => $attribute->name,
//            'templateId' => $template->id,
//            'isLocked' => false,
//            'order' => 0,
            'type' => [
                'machineName' => TypeService::TYPE_TABLE
            ]
        ]);
        //TODO validate by laravel validation tools
        $this->assertJsonStructure($response, array_keys(config('models.Attribute')));
        //todo - assert data properties
    }

    public function testCreateAttributeTypeTableValidationFail()
    {
        $attribute = factory(Attribute::class)->states('table-broken')->make();
        $template = factory(Template::class)->create();

        $typeTable = $this->typeRepository->getTypeByMachineName(TypeService::TYPE_TABLE);

        $response = $this->jsonRequestPostEntityValidationError('templates/' . $template->id . '/attributes', [
            'name' => $attribute->name,
            'typeId' => $typeTable->id,
            'data' => $attribute->data
        ]);
    }

    public function testGetAttributeNotFound()
    {
        $this->jsonRequestGetEntityNotFound('attributes/' . 0);
    }

    public function testDeleteAttributeSuccess()
    {
        /** @var Attribute $attribute */
        $attribute = factory(Attribute::class)->create();
        $this->jsonRequestDelete('attributes', $attribute->getId(), self::DB_TABLE);
    }

    public function testDeleteAttributeNotExistSuccess()
    {
        $this->jsonRequestDelete('attributes', 0, self::DB_TABLE);
    }
}
