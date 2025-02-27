<?php

namespace App\Listeners;

use App\Events\PostApproved;
use App\Mail\PostApprovedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendPostApprovedNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PostApproved $event)
    {
        Mail::to($event->post->user->email)->send(new PostApprovedMail($event->post));
    }
}
