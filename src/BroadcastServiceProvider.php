<?php

namespace Adaojunior\PostgreSqlBroadcastDriver;

use Illuminate\Support\ServiceProvider;
use Illuminate\Broadcasting\BroadcastManager;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        app(BroadcastManager::class)->extend('postgresql', function ($app) {
            $connection = $this->app['config']["broadcasting.connections.postgresql"]['connection'];
            return new PostgresBroadcaster(\DB::connection($connection));
        });
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        //
    }
}
