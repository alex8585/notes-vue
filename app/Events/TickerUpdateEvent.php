<?php

namespace App\Events;

use App\Models\Note;
use App\Events\Event;
use Illuminate\Support\Facades\Log;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TickerUpdateEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $symbol;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $symbol)
    {
        $this->symbol = $symbol;
    }

    public function broadcastOn()
    {
        return new Channel('ticker.' .  $this->symbol['id']);
    }
    
}
