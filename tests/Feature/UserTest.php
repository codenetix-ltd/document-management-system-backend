<?php

namespace Tests\Feature;

use App\Entities\Template;
use App\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Response;
use Tests\Stubs\UserStub;
use Tests\TestCase;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        Resource::withoutWrapping();
    }

    /**
     * Tests user list endpoint
     *
     * @return void
     */
    public function testUserList()
    {
        factory(User::class, 10)->create();

        $response = $this->json('GET', '/api/users');

        $this->assetJsonPaginationStructure($response);

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Tests $user get endpoint
     *
     * @return void
     */
    public function testUserGet()
    {
        $userStub = new UserStub([], true);
        /** @var User $user */
        $user = $userStub->getModel();

        $response = $this->json('GET', '/api/users/' . $user->id);

        $response
            ->assertStatus(200)
            ->assertExactJson($userStub->buildResponse(['id' => $user->id]));
    }

    /**
     * Tests user store endpoint
     *
     * @return void
     */
    public function testUserStore()
    {
        /** @var User $user */
        $userStub = new UserStub();
        $response = $this->json('POST', '/api/users', $userStub->buildRequest([
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
     * Tests user update endpoint
     *
     * @return void
     */
    public function testUserUpdate()
    {
        $userStub = new UserStub([], true);
        $newFullName = 'John Smith';

        /** @var User $user */
        $user = $userStub->getModel();

        $response = $this->json('PUT', '/api/users/' . $user->id, $userStub->buildRequest(['fullName' => $newFullName]));

        $response
            ->assertStatus(200)
            ->assertExactJson($userStub->buildResponse(['fullName' => $newFullName, 'id' => $user->id]));
    }

    /**
     * Tests user update endpoint
     *
     * @return void
     */
    public function testUserUpdateTemplateIds()
    {
        $userStub = new UserStub([], true);

        /** @var User $user */
        $user = $userStub->getModel();
        $templateIds = $user->templates->pluck('id')->toArray();
        $newTemplateId = factory(Template::class)->create()->id;

        $templateIds[0] = $newTemplateId;


        $response = $this->json('PUT', '/api/users/' . $user->id, $userStub->buildRequest(['templateIds' => $templateIds]));

        $response
            ->assertStatus(200)
            ->assertExactJson($userStub->buildResponse(['templateIds' => $templateIds, 'id' => $user->id]));
    }

    /**
     * Tests user delete endpoint
     *
     * @return void
     */
    public function testUserDelete()
    {
        /** @var User $user */
        $user = (new UserStub([], true))->getModel();

        $response = $this->json('DELETE', '/api/users/' . $user->id);

        $response
            ->assertStatus(204);
    }

    public function testLabelDeleteWhichDoesNotExist()
    {
        $response = $this->json('DELETE', '/api/users/' . 0);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /**
     * @throws \Exception
     */
    public function testUserStoreValidationError()
    {
        $labelStub = new UserStub();
        $data = $labelStub->buildRequest();
        $fieldKey = 'fullName';
        unset($data[$fieldKey]);

        $response = $this->json('POST', '/api/users', $data);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([$fieldKey]);
    }

    public function testGetUserNotFound()
    {
        $response = $this->json('GET', '/api/users/' . 0);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

}
