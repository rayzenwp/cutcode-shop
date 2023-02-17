<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RefreshCommand extends Command
{
    protected $signature = 'app:refresh';

    protected $description = 'Refresh application';

    public function handle(): int
    {
        if (app()->isProduction()) {
            return self::FAILURE;
        }
       
       Storage::deleteDirectory('images/products');
       Storage::deleteDirectory('images/brands');

        $this->call('migrate:fresh',[
            '--seed' => true
        ]);

    //     TODO: 
    //     нужно из конфига права на папку доставать иначе будет ошибка
    //     https://stackoverflow.com/questions/28962800/laravel-5-mkdir-filesystemmakedirectory-with-permissions-from-config
    //     https://laravel.com/docs/9.x/filesystem#directories
    //     https://stackoverflow.com/questions/64678596/laravel-store-files-with-permissions-774
    //    Storage::createDirectory('images/products');

        return self::SUCCESS;
    }
}
