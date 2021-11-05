<?php

namespace Edx\MJML;

use Edx\MJML\View\Engines\MjmlEngine;
use Illuminate\Support\ServiceProvider;

class MjmlServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerEngineResolver();
    }

    protected function registerEngineResolver()
    {
        $this->app->resolving(
            'view.engine.resolver',
            fn ($resolver) => $resolver->register(
                'mjml.blade',
                fn () => new MjmlEngine($this->app['blade.compiler'], $this->app['files'])
            )
        );
    }
}
