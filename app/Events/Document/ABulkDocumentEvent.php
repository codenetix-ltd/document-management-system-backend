<?php

namespace App\Events\Document;

use App\Contracts\Models\IUser;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

abstract class ABulkDocumentEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userSubject;

    public $documentIds;

    public function __construct(IUser $userSubject, array $documentIds)
    {
        $this->userSubject = $userSubject;
        $this->documentIds = $documentIds;
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
