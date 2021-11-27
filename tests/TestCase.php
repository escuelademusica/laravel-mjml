<?php

namespace Tests;

use EscuelaDeMusica\MJML\MjmlServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\View;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        View::addLocation(__DIR__ . '/resources/views');
        Artisan::call('view:clear');
    }

    protected function defineEnvironment($app)
    {
        $app['config']->set('mjml.binary_path', __DIR__ . '/../node_modules/.bin/mjml');
    }

    protected function getPackageProviders($app): array
    {
        return [
            MjmlServiceProvider::class,
        ];
    }
}
