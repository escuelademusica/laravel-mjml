<?php

namespace Tests;

use EscuelaDeMusica\MJML\MjmlServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Orchestra\Testbench\TestCase as TestbenchTestCase;

class TestCase extends TestbenchTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        View::addLocation(__DIR__ . '/resources/views');
        Artisan::call('view:clear');
        Config::set(['mjml.binary_path' => __DIR__ . '/../node_modules/.bin/mjml']);
    }

    protected function getPackageProviders($app)
    {
        return [
            MjmlServiceProvider::class,
        ];
    }
}
