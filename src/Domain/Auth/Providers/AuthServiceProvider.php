<?php

namespace Domain\Auth\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as IlluminateAuthServiceProvider;

class AuthServiceProvider extends IlluminateAuthServiceProvider
{
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];


    public function boot():void
    {
        $this->registerPolicies();

        //
    }

    public function register():void
    {
       $this->app->register(ActionsServiceProvider::class);
    }
}