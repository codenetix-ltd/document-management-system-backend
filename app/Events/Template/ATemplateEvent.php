<?php

namespace App\Events\Template;

use App\Contracts\Models\ITemplate;
use App\Contracts\Models\IUser;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

abstract class ATemplateEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userSubject;

    public $template;

    public function __construct(IUser $userSubject, ITemplate $template)
    {
        $this->userSubject = $userSubject;
        $this->template = $template;
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
