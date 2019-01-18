<?php

/*
 * This file is part of the dcynsd/music.
 *
 * (c) dcynsd <dcynsd@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Dcynsd\Music;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(Music::class, function () {
            return new Music();
        });

        $this->app->alias(Music::class, 'music');
    }

    public function provides()
    {
        return [Music::class, 'music'];
    }
}
