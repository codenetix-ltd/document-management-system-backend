<?php

namespace App\Events\Document;

use App\Contracts\Models\IDocument;
use App\Contracts\Models\IUser;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

abstract class ADocumentEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userSubject;

    public $document;

    public function __construct(IUser $userSubject, IDocument $document)
    {
        $this->userSubject = $userSubject;
        $this->document = $document;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
