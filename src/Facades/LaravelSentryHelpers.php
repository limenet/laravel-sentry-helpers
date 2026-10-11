<?php

namespace Limenet\LaravelSentryHelpers\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string|null getRelease()
 * @method static int|null getCacheTtlInSeconds()
 * @method static string getCacheKey()
 *
 * @see \Limenet\LaravelSentryHelpers\LaravelSentryHelpers
 */
class LaravelSentryHelpers extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-sentry-helpers';
    }
}
