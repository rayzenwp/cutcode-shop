<?php

namespace Domain\Catalog\Providers;

use Illuminate\Support\ServiceProvider;

// use Illuminate\Support\Facades\Gate;

class CatalogServiceProvider extends ServiceProvider
{
    public function boot():void
    {
       
    }

    public function register():void
    {
       $this->app->register(ActionsServiceProvider::class);
    }
}