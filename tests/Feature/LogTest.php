<?php

namespace Tests\Feature;

use App\DocumentVersion;
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
use App\Log;
use App\Services\Document\DocumentService;
use App\Tag;
use App\Template;
use App\User;
use Illuminate\Support\Facades\App;
use Tests\ApiTestCase;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class LogTest extends ApiTestCase
{
    private const PATH = 'logs';

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

        $document = factory(DocumentVersion::class)->create()->document;
        event(new DocumentCreateEvent($document));
        event(new DocumentUpdateEvent($document));
        event(new DocumentReadEvent($document));
        event(new DocumentDeleteEvent($document));

        $template = factory(Template::class)->create();
        event(new TemplateCreateEvent($template));
        event(new TemplateUpdateEvent($template));
        event(new TemplateDeleteEvent($template));

        $label = factory(Tag::class)->create();
        event(new LabelCreateEvent($label));
        event(new LabelUpdateEvent($label));
        event(new LabelDeleteEvent($label));

        $newUser = factory(User::class)->create();
        event(new UserCreateEvent($newUser));
        event(new UserUpdateEvent($newUser));
        event(new UserDeleteEvent($newUser));

        $logs = Log::all();

        $this->assertCount(13, $logs); //event() calls count
    }
}
