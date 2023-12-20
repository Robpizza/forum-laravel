<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TranslationMissing
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $key;

    /**
     * Create a new event instance.
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }
}
