<?php

namespace Dcynsd\Music;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(Music::class, function () {
            return new Weather();
        });

        $this->app->alias(Music::class, 'music');
    }

    public function provides()
    {
        return [Music::class, 'music'];
    }
}