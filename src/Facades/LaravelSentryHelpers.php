<?php

namespace Limenet\LaravelSentryHelpers\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Limenet\LaravelSentryHelpers\LaravelSentryHelpers
 */
class LaravelSentryHelpers extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-sentry-helpers';
    }
}
