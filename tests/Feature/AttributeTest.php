<?php

namespace Tests\Feature;

use App\Attribute;
use App\Template;
use App\Type;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\ApiTestCase;

class AttributeTest extends ApiTestCase
{
    public function testCreateAttributeTypeStringSuccess()
    {
        $attribute = factory(Attribute::class)->make();
        $template = Template::first();

        $typeMachineName = 'string';
        $type = Type::where('machine_name', $typeMachineName)->first();

        $response = $this->jsonRequestPostEntityWithSuccess('templates/' . $template->id . '/attributes', [
            'name' => $attribute->name,
            'type_id' => $type->id
        ]);

        dd($response->getOriginalContent());


        dd($response->content());
        $response->assertJson([
            'name' => $attribute->name,
            'template_id' => $template->id,
            'is_locked' => false,
            'order' => 0,
            'type' => [
                'machine_name' => $typeMachineName
            ]
        ]);
        $this->assertJsonStructure($response);
    }

    private function assertJsonStructure(TestResponse $response)
    {
        $response->assertJsonStructure(config('models.tag_response'));
    }
}
