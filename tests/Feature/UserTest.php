<?php

namespace Tests\Feature;

use App\Template;
use App\User;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\ApiTestCase;

class UserTest extends ApiTestCase
{
    private const PATH = 'users';
    private const DB_TABLE = 'users';

    public function testCreateUserSuccess()
    {
        $password = 'password';
        $templatesIds = Template::all()->take(2)->pluck('id')->toArray();

        $user = factory(User::class)->make([
            'password' => bcrypt($password),
        ]);

        Storage::fake('avatars');

        $response = $this->jsonRequestPostEntityWithSuccess(self::PATH, [
            'full_name' => $user->full_name,
            'email' => $user->email,
            'templates_ids' => $templatesIds,
            'password' => $password,
            'password_confirmation' => $password,
            'avatar' => UploadedFile::fake()->image('avatar.jpg')
        ]);

        //Storage::disk('avatars')->assertExists('avatar.jpg'); TODO - check files, clear directory after test

        $response->assertJson([
            'full_name' => $user->full_name,
            'email' => $user->email,
            'templates_ids' => $templatesIds
        ]);
        $this->assertJsonStructure($response, true);
    }

    public function testCreateUserValidationError()
    {
        $response = $this->jsonRequestPostEntityValidationError(self::PATH, [
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        $response->assertJsonValidationErrors(['email', 'full_name']);
    }

    public function testGetUserSuccess()
    {
        $user = factory(User::class)->create();

        $response = $this->jsonRequestGetEntitySuccess(self::PATH . '/' .  $user->id);
        $response->assertJson([
            'full_name' => $user->full_name,
            'email' => $user->email,
        ]);
        $this->assertJsonStructure($response);
    }

    public function testGetUserNotFound()
    {
        $this->jsonRequestGetEntityNotFound(self::PATH . '/' . 0);
    }

    public function testUpdateUserSuccess()
    {
        $user = factory(User::class)->create();
        $userNameNew = 'New Full Name';
        $templatesIds = Template::all()->take(1)->pluck('id')->toArray(); //TODO - можно ли тут так делать?

        $response = $this->jsonRequestPutEntityWithSuccess(self::PATH .'/' . $user->id, [
            'full_name' => $userNameNew,
            'templates_ids' => $templatesIds
        ]);
        $response->assertJson([
            'full_name' => $userNameNew,
            'templates_ids' => $templatesIds
        ]);
        $this->assertJsonStructure($response);
    }

    public function testDeleteTagSuccess()
    {
        $user = factory(User::class)->create();
        $this->jsonRequestDelete(self::PATH, $user->id, self::DB_TABLE);
    }

    public function testDeleteTagNotExistSuccess()
    {
        $this->jsonRequestDelete(self::PATH, 0, self::DB_TABLE);
    }

    public function testListOfUsersWithPaginationSuccess()
    {
        factory(User::class, 20)->create();

        $this->jsonRequestObjectsWithPagination(self::PATH);
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
