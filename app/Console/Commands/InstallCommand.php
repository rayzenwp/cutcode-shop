<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'app:install';

    protected $description = 'Instalation application';

    public function handle(): int
    {
        $this->call('storage:link');
        // $this->call('telescope:install'); // already installed and published
        $this->call('migrate');

        return self::SUCCESS;
    }
}
