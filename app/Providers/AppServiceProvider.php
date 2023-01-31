<?php

namespace App\Providers;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Connection;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Foundation\Http\Kernel;
use Illuminate\Contracts\Http\Kernel as KernelContract;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        //!app()->runningInConsole
        Model::shouldBeStrict(!app()->isProduction());

        if (app()->isProduction()) {
            DB::whenQueryingForLongerThan(CarbonInterval::seconds(5), function (Connection $connection, QueryExecuted $event) {
                logger()
                    ->channel('telegram')
                    ->debug('whenQueryingForLongerThan '.$connection->totalQueryDuration());
            });
    
            // Если внутри функции нет this можно вызывать ее как static function
            DB::listen(static function ($query) {
                if ($query->time > 1000) {
                    //TODO: враппер? что? добавить
                    logger()
                    ->channel('telegram')
                    ->debug('Query too long '.$query->sql, $query->bindings);
                }
            });
    
            $kernel = app(KernelContract::class);
            $kernel->whenRequestLifecycleIsLongerThan(
                CarbonInterval::seconds(4),
                function () {
                    logger()
                    ->channel('telegram')
                    ->debug('whenRequestLifecycleIsLongerThan: '.request()->url());
                }
            );
        }
    }
}
