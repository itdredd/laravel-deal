<?php

namespace App\Events;

// app/Events/MessageSent.php

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\DealMessage;
use App\Models\User;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $type;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($type, $message)
    {
        $this->type = $type;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        $id = 0;
        switch ($this->type) {
            case 'deal': {
                $id = $this->message->deal_id;
                break;
            }
            case 'conversation': {
                $id = $this->message->conversation_id;
                break;
            }
        }
        return new PrivateChannel($this->type.'-message.'.$id);
    }
}

