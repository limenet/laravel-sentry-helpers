<?php

namespace Limenet\LaravelSentryHelpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Limenet\LaravelSentryHelpers\Facades\LaravelSentryHelpers as Facade;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelSentryHelpersServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-sentry-helpers')
            ->hasConfigFile();
    }

    public function packageBooted()
    {
        $this->app->singleton('laravel-sentry-helpers', LaravelSentryHelpers::class);

        $release = Cache::remember(Facade::getCacheKey(), Facade::getCacheTtlInSeconds(), fn () => Facade::getRelease());

        if ($release !== null) {
            Config::set(
                'sentry.release',
                $release
            );
        }
    }
}
