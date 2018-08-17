<?php

namespace Tests\Feature;

use App\Entities\Template;
use App\Entities\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\Stubs\UserStub;
use Tests\TestCase;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class UserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Setup the test environment.
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
     * List of users
     * @return void
     */
    public function testUserList()
    {
        factory(User::class, 10)->create();

        $response = $this->json('GET', self::API_ROOT . 'users');

        $response->assertStatus(Response::HTTP_OK);
        $this->assetJsonPaginationStructure($response);
    }

    /**
     * Get user by id
     * @return void
     */
    public function testUserGet()
    {
        $userStub = new UserStub([], true);
        /** @var User $user */
        $user = $userStub->getModel();

        $response = $this->json('GET', self::API_ROOT . 'users/' . $user->id);

        $response
            ->assertStatus(200)
            ->assertExactJson($userStub->buildResponse(['id' => $user->id]));
    }

    /**
     * Get current user
     * @throws \Exception
     * @return void
     */
    public function testCurrentUserGet()
    {
        $response = $this->json('GET', self::API_ROOT . 'users/current');

        $userStub = new UserStub([], true, [], $this->authUser);

        $response
            ->assertStatus(200)
            ->assertExactJson($userStub->buildResponse([
                'roles' => $response->decodeResponseJson('roles')
            ]));
    }


    /**
     * Save user
     * @throws \Exception The exception that triggered the error response (if applicable).
     * @return void
     */
    public function testUserStore()
    {
        /** @var User $user */
        $userStub = new UserStub();
        $response = $this->json('POST', self::API_ROOT . 'users', $userStub->buildRequest([
            'password' => 'uSERpAsSWOrd',
            'passwordConfirmation' => 'uSERpAsSWOrd',
        ]));

        $response->assertStatus(Response::HTTP_CREATED);

        $user = User::find($response->decodeResponseJson()['id']);
        $response
            ->assertExactJson($userStub->buildResponse([
                'id' => $user->id
            ]));
    }

    /**
     * Update user
     * @return void
     */
    public function testUserUpdate()
    {
        $userStub = new UserStub([], true);
        $newFullName = 'John Smith';

        /** @var User $user */
        $user = $userStub->getModel();

        $response = $this->json('PUT', self::API_ROOT . 'users/' . $user->id, $userStub->buildRequest(['fullName' => $newFullName]));

        $response
            ->assertStatus(200)
            ->assertExactJson($userStub->buildResponse(['fullName' => $newFullName, 'id' => $user->id]));
    }

    /**
     * Update templatesIds in user
     * @return void
     */
    public function testUserUpdateTemplatesIds()
    {
        $userStub = new UserStub([], true);

        /** @var User $user */
        $user = $userStub->getModel();
        $templatesIds = $user->templates->pluck('id')->toArray();
        $newTemplateId = factory(Template::class)->create()->id;

        $templatesIds[0] = $newTemplateId;

        $response = $this->json('PUT', self::API_ROOT . 'users/' . $user->id, $userStub->buildRequest(['templatesIds' => $templatesIds]));

        $response
            ->assertStatus(200)
            ->assertExactJson($userStub->buildResponse(['templatesIds' => $templatesIds, 'id' => $user->id]));
    }

    /**
     * Delete user
     * @return void
     */
    public function testUserDelete()
    {
        /** @var User $user */
        $user = (new UserStub([], true))->getModel();

        $response = $this->json('DELETE', self::API_ROOT . 'users/' . $user->id);

        $response
            ->assertStatus(204);
    }

    /**
     * Delete user which does not exist
     * @return void
     */
    public function testUserDeleteWhichDoesNotExist()
    {
        $response = $this->json('DELETE', self::API_ROOT . 'users/' . 0);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * Save user with validation error
     * @throws \Exception The exception that triggered the error response (if applicable).
     * @return void
     */
    public function testUserStoreValidationError()
    {
        $labelStub = new UserStub();
        $data = $labelStub->buildRequest();
        $fieldKey = 'fullName';
        unset($data[$fieldKey]);

        $response = $this->json('POST', self::API_ROOT . 'users', $data);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([$fieldKey]);
    }

    /**
     * User not found
     * @return void
     */
    public function testGetUserNotFound()
    {
        $response = $this->json('GET', self::API_ROOT . 'users/' . 0);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
