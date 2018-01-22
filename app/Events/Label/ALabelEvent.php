<?php

namespace App\Events\Label;

use App\Contracts\Models\ILabel;
use App\Contracts\Models\IUser;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

abstract class ALabelEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userSubject;

    public $label;

    public function __construct(IUser $userSubject, ILabel $label)
    {
        $this->userSubject = $userSubject;
        $this->label = $label;
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
