<?php

namespace JustBetter\AkeneoProducts\Tests;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use JustBetter\AkeneoClient\ServiceProvider as AkeneoServiceProvider;
use JustBetter\AkeneoProducts\ServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Spatie\Activitylog\ActivitylogServiceProvider;

abstract class TestCase extends BaseTestCase
{
    use LazilyRefreshDatabase;

    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
            AkeneoServiceProvider::class,
            ActivitylogServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        activity()->disableLogging();
    }
}
