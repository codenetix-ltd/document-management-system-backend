<?php

namespace Tests\Feature;

use App\DocumentVersion;
use App\Entities\Log;
use App\Entities\Template;
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
use App\Http\Resources\LogCollectionResource;
use App\Http\Resources\LogResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Response;
use Tests\Stubs\DocumentStub;
use Tests\Stubs\LabelStub;
use Tests\Stubs\UserStub;
use Tests\TestCase;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class LogTest extends TestCase
{
    private const PATH = 'logs';

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
     * Tests log list endpoint
     *
     * @return void
     */
    public function testLogList()
    {
        factory(Log::class, 5)->create(['user_id' => $this->authUser->id]);
        factory(Log::class, 5)->create(['user_id' => factory(User::class)->create()->id]);

        $response = $this
            ->actingAs($this->authUser)
            ->json('GET', '/api/logs');

        $this->assetJsonPaginationStructure($response);

        $response->assertStatus(Response::HTTP_OK);
        $responseArr = $response->decodeResponseJson();

        $this->assertCount(5, $responseArr['data']);
    }


    public function testDocumentReadEventLogSuccess()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $dv = factory(DocumentVersion::class)->create();

        /** @var DocumentService $documentService */
        $documentService = App::make(DocumentService::class);
        $documentService->get($dv->document_id);

        $this->assertCount(1, Log::all());
    }

    public function testGetLogsSuccess()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        factory(Log::class, 3)->create([
            'user_id' => $user->id,
            'reference_type' => 'user',
            'reference_id' => $user->id,
        ]);

        $this->jsonRequestObjectsWithPagination(self::PATH);
    }

    public function testEventsLogs()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

//        //TODO documentEvents
//        $document = (new DocumentStub())->buildModel()->getModel();
//        event(new DocumentCreateEvent($document));
//        event(new DocumentUpdateEvent($document));
//        event(new DocumentReadEvent($document));
//        event(new DocumentDeleteEvent($document));

        //TODO use stub
        $template = factory(Template::class)->create();
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

        //TODO 13
        $this->assertCount(9, $logs); //event() calls count
    }
}
