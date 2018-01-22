<?php

namespace App\Events\User;

use App\Contracts\Models\IUser;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

abstract class AUserEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userSubject;

    public $user;

    public function __construct(IUser $userSubject, IUser $user)
    {
        $this->userSubject = $userSubject;
        $this->user = $user;
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
