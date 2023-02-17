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
    public function boot(): void
    {
        //!app()->runningInConsole
        Model::shouldBeStrict(!app()->isProduction());

        if (app()->isProduction()) {
            DB::whenQueryingForLongerThan(
                CarbonInterval::seconds(5), 
                function (Connection $connection, QueryExecuted $event) {
                    //если на TelegramBotApi добавляется очередь то тут нужно сделать проверку
                    // иначе будет вечный цикл
                    // if ($connection->getName())
                    // logger($connection->getName());
                    logger()
                        ->channel('telegram')
                        ->debug('whenQueryingForLongerThan '.$connection->totalQueryDuration());
                }
            );
    
            // Если внутри функции нет this можно вызывать ее как static function
            DB::listen(static function ($query) {
                if ($query->time > 100) {
                    //TODO: враппер? что? добавить
                    logger()
                    ->channel('telegram')
                    ->debug('Query longer than 1s: '.$query->sql, $query->bindings);
                }
            });
    
            app(KernelContract::class)->whenRequestLifecycleIsLongerThan(
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
