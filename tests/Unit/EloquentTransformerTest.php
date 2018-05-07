<?php

namespace Tests\Unit;

use App\Attribute;
use App\Services\System\EloquentTransformer;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class EloquentTransformerTest extends TestCase
{
    public function testTransform()
    {
        $transformer = new EloquentTransformer();
        $model = new Attribute();

        $transformer->transform([
            'name' => 'test',
            'something' => 'sdfsd',
        ], $model);

        $this->assertEquals('test', $model->getName());
        $this->assertEquals('test', $model->name);
        $this->assertNull($model->something);
    }
}
