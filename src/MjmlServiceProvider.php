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

    public function boot()
    {
        $this->bootDirectives();
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

        $this->app['view']->addExtension('mjml.blade.php', 'mjmlblade');
        $this->app['view']->addExtension('mjml', 'mjml');
    }

    public function bootDirectives()
    {
        $this->app['blade.compiler']->directive(
            'mj_include',
            fn ($view, $data = []) => app(MjmlDirective::class)->include($view, $data)
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
