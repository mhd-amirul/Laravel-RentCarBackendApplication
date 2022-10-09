<?php

namespace App\Listeners;

use App\Events\verifyAccountEvent;
use App\Mail\sendOtp;
use Illuminate\Support\Facades\Mail;

class verifyAccountListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\verifyAccountEvent  $event
     * @return void
     */
    public function handle(verifyAccountEvent $event)
    {
        Mail::to($event->user['email'])->send(new sendOtp($event->user));
    }
}
