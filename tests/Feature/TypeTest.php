<?php

namespace Tests\Feature;

use App\Entities\Type;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class TypeTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * Clean up the testing environment before the next test.
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Tests type list endpoint
     *
     * @return void
     */
    public function testTypeList()
    {
        factory(Type::class, 10)->create();
        $total = Type::all()->count();

        $response = $this->json('GET', self::API_ROOT . 'types');

        $response->assertJsonCount($total);
        $response->assertStatus(200);
    }
}
