<?php

namespace Collejo\App\Console\Commands;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\ConfigCacheCommand;

class Install extends ConfigCacheCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Collejo';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (app()->isInstalled()) {
            $this->error('Collejo is already installed. Exiting...');
            exit();
        }

        $this->call('migrate:copy');
        $this->call('admin:create');
    }
}