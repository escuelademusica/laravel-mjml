<?php

namespace Tests;

use Edx\MJML\MjmlServiceProvider;
use Illuminate\Support\Facades\View;
use Orchestra\Testbench\TestCase as TestbenchTestCase;

class TestCase extends TestbenchTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        View::addLocation(__DIR__ . '/resources/views');
    }

    protected function getPackageProviders($app)
    {
        return [
            MjmlServiceProvider::class,
        ];
    }
}
