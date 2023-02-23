<?php

namespace App\Listeners;

use App\Notifications\NewUserNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailNewUserListener
{
    public function handle(Registered $event)
    {
        // TOOD: read more about Notifications
        $event->user->notify(new NewUserNotification());
    }
}
