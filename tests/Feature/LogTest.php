<?php

namespace Tests\Feature;

use App\Entities\Document;
use App\Entities\Log;
use App\Entities\User;
use App\Events\Document\DocumentCreateEvent;
use App\Events\Document\DocumentDeleteEvent;
use App\Events\Document\DocumentReadEvent;
use App\Events\Document\DocumentUpdateEvent;
use App\Events\Label\LabelCreateEvent;
use App\Events\Label\LabelDeleteEvent;
use App\Events\Label\LabelUpdateEvent;
use App\Events\Template\TemplateCreateEvent;
use App\Events\Template\TemplateDeleteEvent;
use App\Events\Template\TemplateUpdateEvent;
use App\Events\User\UserCreateEvent;
use App\Events\User\UserDeleteEvent;
use App\Events\User\UserUpdateEvent;
use App\Services\DocumentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Tests\Stubs\DocumentStub;
use Tests\Stubs\LabelStub;
use Tests\Stubs\TemplateStub;
use Tests\Stubs\UserStub;
use Tests\TestCase;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class LogTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup the test environment.
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        Resource::withoutWrapping();
    }

    /**
     * List of logs
     * @throws \Exception The exception that triggered the error response (if applicable).
     * @return void
     */
    public function testLogListWithoutArgs()
    {
        factory(Log::class, 5)->create(['user_id' => $this->authUser->id]);
        factory(Log::class, 5)->create(['user_id' => factory(User::class)->create()->id]);

        $response = $this
            ->actingAs($this->authUser)
            ->json('GET', self::API_ROOT. 'logs?sort[body]=desc')
            ->assertStatus(Response::HTTP_OK);

        $this->assetJsonPaginationStructure($response);
        $decodedResponse = $response->decodeResponseJson();
        $item = $decodedResponse['data'][0];

        $response->assertJsonStructure([
            'id',
            'user' => [
                'id',
                'fullName',
                'email',
            ],
            'body',
            'referenceId',
            'referenceType',
            'link' => [
                'title',
                'url'
            ],
            'createdAt',
            'updatedAt'
        ], $item);

        $this->assertCount(10, $decodedResponse['data']);
    }

    public function testLogListSortByBody()
    {
        factory(Log::class)->create(['body' => 'a', 'user_id' => $this->authUser->id]);
        factory(Log::class)->create(['body' => 'z', 'user_id' => $this->authUser->id]);

        $response = $this
            ->actingAs($this->authUser)
            ->json('GET', self::API_ROOT . 'logs?sort[body]=desc');

        $response->assertStatus(Response::HTTP_OK);

        $this->assetJsonPaginationStructure($response);

        $decodedResponse = $response->decodeResponseJson();

        $this->assertEquals('z',$decodedResponse['data'][0]['body']);
        $this->assertEquals('a',$decodedResponse['data'][1]['body']);

    }

    public function testLogListSortByUser()
    {
        $u1 = (new UserStub(['full_name' => 'a'], true))->getModel();
        $u2 = (new UserStub(['full_name' => 'z'], true))->getModel();
        
        factory(Log::class)->create(['user_id' => $u1->id]);
        factory(Log::class)->create(['user_id' => $u2->id]);

        $response = $this
            ->actingAs($this->authUser)
            ->json('GET', self::API_ROOT . 'logs?sort[user.fullName]=desc');

        $response->assertStatus(Response::HTTP_OK);

        $this->assetJsonPaginationStructure($response);

        $decodedResponse = $response->decodeResponseJson();

        $this->assertEquals('z',$decodedResponse['data'][0]['user']['fullName']);
        $this->assertEquals('a',$decodedResponse['data'][1]['user']['fullName']);
    }

    /**
     * Log document reading event
     * @return void
     */
    public function testDocumentReadEventLogSuccess()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        /** @var Document $document */
        $document = (new DocumentStub([], true))->getModel();

        /** @var DocumentService $documentService */
        $documentService = App::make(DocumentService::class);
        $documentService->find($document->id);

        $this->assertCount(1, Log::all());
    }

    /**
     * Log events
     * @return void
     */
    public function testEventsLogs()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $document = (new DocumentStub([], true))->getModel();
        event(new DocumentCreateEvent($document));
        event(new DocumentUpdateEvent($document));
        event(new DocumentReadEvent($document));
        event(new DocumentDeleteEvent($document));

        $template = (new TemplateStub([], true))->getModel();
        event(new TemplateCreateEvent($template));
        event(new TemplateUpdateEvent($template));
        event(new TemplateDeleteEvent($template));

        $label = (new LabelStub([], true))->getModel();
        event(new LabelCreateEvent($label));
        event(new LabelUpdateEvent($label));
        event(new LabelDeleteEvent($label));

        $newUser = (new UserStub([], true))->getModel();
        event(new UserCreateEvent($newUser));
        event(new UserUpdateEvent($newUser));
        event(new UserDeleteEvent($newUser));

        $logs = Log::all();

        $this->assertCount(13, $logs); //event() calls count
    }
}
