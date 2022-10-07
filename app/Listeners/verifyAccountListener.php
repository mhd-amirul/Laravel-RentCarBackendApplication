<?php

namespace App\Listeners;

use App\Events\verifyAccountEvent;
use App\Mail\sendOtp;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
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
        return response()->json($event->user);
        Mail::to($event->user->email)->send(new sendOtp($event->user));
    }
}
