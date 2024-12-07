<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StudentTrashInsertLogEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    // Constructor to pass data
    public function __construct($message)
    {
        $this->message = $message;
    }

    // Define the broadcast channel
    public function broadcastOn()
    {
        return new Channel('student-trash-log');
    }

    // Define the data to be broadcasted
    public function broadcastWith()
    {
        return [
            'message' => $this->message,
        ];
    }
}
