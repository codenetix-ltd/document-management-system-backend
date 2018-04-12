<?php

namespace Tests\Feature;

use App\Attribute;
use App\Contracts\Repositories\ITypeRepository;
use App\Services\Type\TypeService;
use App\Template;
use Tests\ApiTestCase;

class AttributeTest extends ApiTestCase
{
    /** @var ITypeRepository $typeRepository */
    private $typeRepository;

    public function setUp()
    {
        parent::setUp();
        $this->typeRepository = $this->app->make(ITypeRepository::class);
    }

    public function qtestCreateAttributeTypeStringSuccess()
    {
        $attribute = factory(Attribute::class)->make();
        $template = factory(Template::class)->create();

        $type = $this->typeRepository->getTypeByMachineName(TypeService::TYPE_STRING);

        $response = $this->jsonRequestPostEntityWithSuccess('templates/' . $template->id . '/attributes', [
            'name' => $attribute->name,
            'typeId' => $type->id
        ]);

        $response->assertJson([
            'name' => $attribute->name,
            'templateId' => $template->id,
            'isLocked' => false,
            'order' => 0,
            'type' => [
                'machineName' => TypeService::TYPE_STRING
            ]
        ]);
        $this->assertJsonStructure($response, config('models.attribute_response'));
    }

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

        dd($response->getOriginalContent());
        $response->assertJson([
            'name' => $attribute->name,
            'templateId' => $template->id,
            'isLocked' => false,
            'order' => 0,
            'type' => [
                'machineName' => TypeService::TYPE_TABLE
            ]
        ]);
        $this->assertJsonStructure($response, config('models.attribute_response'));
    }
}
