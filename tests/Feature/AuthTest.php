<?php

namespace Tests\Feature;

use App\Entities\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Passport;
use Tests\CreatesApplication;

class AuthTest extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    /**
     * Setup the test environment.
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        Resource::withoutWrapping();

        $this->artisan("dms:passport-init", []);
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
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    private function getPasswordClient()
    {
        return DB::table('oauth_clients')->where('password_client', 1)->first();
    }

    /**
     * Get password grant token
     * @return void
     */
    public function testPasswordGrantToken()
    {
        $client = $this->getPasswordClient();

        $response = $this->json('POST', '/api/v1/oauth/token', [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => 'admin@example.com',
            'password' => 'admin'
        ]);

        $response->assertJsonStructure([
            'token_type',
            'expires_in',
            'access_token',
            'refresh_token'
        ]);
    }

    /**
     * Logout
     * @return void
     */
    public function testLogout()
    {
        $this->authUser = User::whereFullName('admin')->first();
        Passport::actingAs($this->authUser);

        $response = $this->json('POST', '/api/v1/oauth/logout');
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
