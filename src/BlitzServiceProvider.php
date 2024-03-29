<?php

namespace CraigPaul\Blitz;

use CraigPaul\Blitz\Console\Commands\TestMakeCommand;
use Illuminate\Support\ServiceProvider;

class BlitzServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/blitz.php', 'blitz');

        if (! $this->app['config']->get('blitz.enabled')) {
            return;
        }

        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        if ($this->app->runningInConsole()) {
            $this->commands([
                TestMakeCommand::class,
            ]);
        }
    }
}
