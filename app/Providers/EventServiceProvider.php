<?php

namespace App\Providers;

use App\Listeners\SendEmailNewUserListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

// NOTE: EVENTS 1.Входная точка иницализации событий.
// https://www.youtube.com/watch?v=9VsU9WzFvaw&ab_channel=%D0%9F%D1%80%D0%BE%D1%81%D1%82%D0%BE%D0%BELaravel.CutCode
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [

        // NOTE: EVENTS 2. пример события(что произошло). В данном случае вызывается при регистрации нового пользователя events(new Registered) 
        // Если пользователь зарегистрирован то ...
        Registered::class => [
            SendEmailNewUserListener::class,

            // NOTE: EVENTS 3. ... ему отправляеться эмеил уведомление с верификацией
            // Это Listener
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
