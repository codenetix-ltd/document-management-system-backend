<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Tests\CreatesApplication;

class AuthTest extends BaseTestCase
{
    use RefreshDatabase;

    use CreatesApplication;

    /**
     * Setup the test environment.
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        Resource::withoutWrapping();

        $this->artisan("db:seed");
        $this->artisan("dms:passport-init", []);
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
}
