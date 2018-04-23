<?php

namespace Tests\Unit;

use App\Services\Components\Validation\ValidationRulesKeeper;
use Illuminate\Config\Repository;


/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class ValidationRulesKeeperTest extends TestCase
{
    public function testSuccessGetAllRules() {
        $configStub = $this->createMock(Repository::class);
        $configStub->method('get')->willReturn([
            'id' => 'integer|min:2',
            'name' => 'required|string'
        ], [
            'name' => 'min:3|unique',
            'lastName' => 'string|required'
        ]);
        $validationRulesKeeper = new ValidationRulesKeeper($configStub);

        $result = $validationRulesKeeper->getRules('User');

        $this->assertEquals([
            'id' => 'integer|min:2',
            'name' => 'required|string|min:3|unique',
            'lastName' => 'string|required'
        ], $result);
    }

    public function testSuccessGetRules() {
        $initArray = [
            'id' => 'integer|min:2',
            'name' => 'required|string'
        ];

        $configStub = $this->createMock(Repository::class);
        $configStub->method('get')->willReturn($initArray, []);
        $validationRulesKeeper = new ValidationRulesKeeper($configStub);

        $result = $validationRulesKeeper->getRules('User');

        $this->assertEquals($initArray, $result);
    }

    public function testSuccessGetAdditionalRules() {
        $initArray = [
            'name' => 'min:3|unique',
            'lastName' => 'string|required'
        ];
        $configStub = $this->createMock(Repository::class);
        $configStub->method('get')->willReturn([], $initArray);
        $validationRulesKeeper = new ValidationRulesKeeper($configStub);

        $result = $validationRulesKeeper->getRules('User');

        $this->assertEquals($initArray, $result);
    }
}
