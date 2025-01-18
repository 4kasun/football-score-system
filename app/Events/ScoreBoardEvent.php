<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ScoreBoardEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $teams;
    public $score;
    public $status;

    /**
     * Create a new event instance.
     */
    public function __construct($teams, $score, $status)
    {
        $this->teams = $teams;
        $this->score = $score;
        $this->status = $status;
    }

    public function broadcastWith(): array
    {
        return [
            'teams' => $this->teams,
            'score' => $this->score,
            'status' => $this->status
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('football-match'),
        ];
    }
}
