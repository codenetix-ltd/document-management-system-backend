<?php

namespace Tests\Feature;

use App\Template;
use App\User;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserTest extends TestCase
{
    public const PATH = 'users';

    public function testCreateUserSuccess()
    {
        $password = 'password';
        $templatesIds = Template::all()->take(2)->pluck('id')->toArray();

        $user = factory(User::class)->make([
            'password' => bcrypt($password),
        ]);

        Storage::fake('avatars');

        $response = $this->actingAs($this->authUser)->json('POST', self::API_ROOT . self::PATH, [
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
                'full_name' => $user->full_name,
                'email' => $user->email,
                'templates_ids' => $templatesIds
            ]);
        $this->assertJsonStructure($response, true);
    }

    public function testCreateUserFailEmptyEmailAndFullName()
    {
        $response = $this->actingAs($this->authUser)->json('POST', self::API_ROOT . self::PATH, [
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'full_name']);
    }

    public function testGetUserSuccess()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($this->authUser)->json('GET', self::API_ROOT . self::PATH . '/' .  $user->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'full_name' => $user->full_name,
                'email' => $user->email,
            ]);
        $this->assertJsonStructure($response);
    }

    public function testGetUserFail()
    {
        $response = $this->actingAs($this->authUser)->json('GET', self::API_ROOT . self::PATH .'/' . 0);
        $response->assertStatus(404);
    }

    public function testUpdateUserSuccess()
    {
        $user = factory(User::class)->create();
        $userNameNew = 'New Full Name';
        $templatesIds = Template::all()->take(1)->pluck('id')->toArray();

        $response = $this->actingAs($this->authUser)->json('PUT', self::API_ROOT . self::PATH .'/' . $user->id, [
            'full_name' => $userNameNew,
            'templates_ids' => $templatesIds
        ]);

        $response->assertStatus(200)->assertJson([
            'full_name' => $userNameNew,
        ]);
        $this->assertJsonStructure($response);
    }

    public function testDeleteUserSuccess()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($this->authUser)->json('DELETE', self::API_ROOT . self::PATH . '/' . $user->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('users', [
            'id' => $user->id
        ]);
    }

    public function testDeleteUserNotExistSuccess()
    {
        $userId = 0;
        $response = $this->actingAs($this->authUser)->json('DELETE', self::API_ROOT . self::PATH . '/' . $userId);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('users', [
            'id' => $userId
        ]);
    }

    public function testListOfUsersWithPaginationSuccess()
    {
        $users = factory(User::class, 20)->create();

        $response = $this->actingAs($this->authUser)->json('GET', self::API_ROOT . self::PATH);
        $response->assertStatus(200);
        $this->assetJsonPaginationStructure($response);
    }

    private function assertJsonStructure(TestResponse $response, $withAvatar = false)
    {
        $structure = [
            'full_name',
            'email',
            'templates_ids',
            'created_at',
            'updated_at'
        ];

        if ($withAvatar) {
            $structure['avatar'] = [
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
