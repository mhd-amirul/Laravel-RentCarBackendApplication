<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class verifyAccountEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $otp;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($otp)
    {
        return $this->otp = $otp;
    }
}
