<?php

namespace Tests\Feature;

use App\Attribute;
use App\Contracts\Repositories\ITypeRepository;
use App\Services\Type\TypeService;
use App\Template;
use Tests\ApiTestCase;

class AttributeTest extends ApiTestCase
{
    protected const DB_TABLE = 'attributes';

    /** @var ITypeRepository $typeRepository */
    private $typeRepository;

    public function setUp()
    {
        parent::setUp();
        $this->typeRepository = $this->app->make(ITypeRepository::class);
    }

    public function testCreateAttributeTypeStringSuccess()
    {
        //TODO - создать свою фабрику, где можно было бы получать модели по интерфейсу а не по классу напрямую
        $attribute = factory(Attribute::class)->make();
        $template = factory(Template::class)->create();

        $response = $this->jsonRequestPostEntityWithSuccess('templates/' . $template->id . '/attributes', [
            'name' => $attribute->name,
            'typeId' => $attribute->type_id
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
        //todo - assert data properties
    }

    public function testCreateAttributeTypeStringWithoutDataValidationFail()
    {
        $template = factory(Template::class)->create();
        $this->jsonRequestPostEntityValidationError('templates/' . $template->id . '/attributes', []);
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

    public function testGetAttributeSuccess()
    {
        /** @var Attribute $attribute */
        $attribute = factory(Attribute::class)->create();

        $response = $this->jsonRequestGetEntitySuccess('attributes/' . $attribute->getId());
        $response->assertJson([
            'name' => $attribute->getName(),
            'templateId' => $attribute->getTemplateId(),
            'isLocked' => $attribute->isLocked(),
            'parentAttributeId' => $attribute->getParentAttributeId(),
            'type' => [
                'id' => $attribute->getTypeId()
            ]
        ]);
        $this->assertJsonStructure($response, config('models.attribute_response'));
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

    public function testDeleteTagNotExistSuccess()
    {
        $this->jsonRequestDelete('attributes', 0, self::DB_TABLE);
    }

    public function testListOfTagsWithPaginationSuccess()
    {
        /** @var Template $template */
        $template = factory(Template::class)->create();
        factory(Attribute::class, 20)->create([
            'template_id' => $template->getId()
        ]);

        $this->jsonRequestObjectsWithPagination('templates/' . $template->getId() . '/attributes');
    }
}
