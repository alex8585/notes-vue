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

class TestEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $note;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Note $note)
    {
        //Storage::put('1112.txt', '1111');
        //dd($note);
        $this->note = $note;
    }

    public function broadcastOn()
    {
        Log::info('TestEvent1!');
        return new Channel('chat');
        //return new PresenceChannel('chat');
    }
    // public function broadcastAs()
    // {
    //     return 'TestEvent';
    // }
}
