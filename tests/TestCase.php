<?php

namespace Limenet\LaravelSentryHelpers\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Limenet\LaravelSentryHelpers\LaravelSentryHelpersServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Limenet\\LaravelSentryHelpers\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelSentryHelpersServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
        config()->set('cache.driver', 'array');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-sentry-helpers_table.php.stub';
        $migration->up();
        */
    }
}
