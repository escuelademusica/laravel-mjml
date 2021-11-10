<?php

namespace EscuelaDeMusica\MJML;

use EscuelaDeMusica\MJML\View\Engines\MjmlEngine;
use Illuminate\Support\ServiceProvider;

class MjmlServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerEngineResolver();
        $this->registerConfig();
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

    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/mjml.php',
            'mjml'
        );
    }
}
