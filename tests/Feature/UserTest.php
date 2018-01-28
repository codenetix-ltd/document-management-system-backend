<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserTest extends TestCase
{
    protected $authUser;

    public function testCreateUserSuccess()
    {
        $password = 'password';
        $templatesIds = [1, 2];

        $user = factory(User::class)->make([
            'password' => bcrypt($password),
        ]);

        Storage::fake('avatars');

        $response = $this->actingAs($this->authUser)->json('POST', self::API_ROOT . 'users', [
            'full_name' => $user->full_name,
            'email' => $user->email,
            'templates_ids' => $templatesIds,
            'password' => $password,
            'password_confirmation' => $password,
            'avatar' => UploadedFile::fake()->image('avatar.jpg')
        ]);

        //Storage::disk('avatars')->assertExists('avatar.jpg'); TODO - check files, clear directory after test
        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'full_name' => $user->full_name,
                    'email' => $user->email,
                    'templates_ids' => $templatesIds
                ]
            ]);
        $this->assertJsonStructure($response, true);
    }

    public function testCreateUserFailEmptyEmailAndFullName()
    {
        $response = $this->actingAs($this->authUser)->json('POST', self::API_ROOT . 'users', [
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'full_name']);

    }

    public function testUpdateUserSuccess()
    {
        $user = factory(User::class)->create();
        $userNameNew = 'New Full Name';
        $templatesIds = [3];

        $response = $this->actingAs($this->authUser)->json('PUT', self::API_ROOT . 'users/' . $user->id, [
            'full_name' => $userNameNew,
            'templates_ids' => $templatesIds
        ]);

        $response->assertStatus(200)->assertJson([
            'data' => [
                'full_name' => $userNameNew,
            ]
        ]);
        $this->assertJsonStructure($response);
    }

    private function assertJsonStructure(TestResponse $response, $withAvatar = false)
    {
        $structure = [
            'data' => [
                'full_name',
                'email',
                'templates_ids',
                'created_at',
                'updated_at'
            ]
        ];

        if ($withAvatar) {
            $structure['data']['avatar'] = [
                'id',
                'path',
                'original_name',
                'created_at',
                'updated_at'
            ];
        }

        $response->assertJsonStructure($structure);
    }
}
