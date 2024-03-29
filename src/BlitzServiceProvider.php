<?php

namespace CraigPaul\Blitz;

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
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
    }
}
