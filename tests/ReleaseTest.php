<?php

use Illuminate\Support\Facades\Config;
use Limenet\LaravelSentryHelpers\Facades\LaravelSentryHelpers;

beforeEach(function () {
    foreach (['composer.json', 'composer.json'] as $file) {
        $path = base_path($file);
        if (file_exists($path)) {
            unlink($path);
        }
    }
});

it('does not crash when no package file is present', function () {
    expect(LaravelSentryHelpers::getVersion())->toBeNull();
});

it('fails gracefully when version is missing in package file', function () {
    composerJson(version: null)->expect(LaravelSentryHelpers::getVersion())->toBeNull();
});

it('fails gracefully when name is missing in package file', function () {
    composerJson(name: null)->expect(LaravelSentryHelpers::getName())->toBeNull();
});

it('fails gracefully when reading corrupt package file', function () {
    corrupt()->expect(LaravelSentryHelpers::getVersion())->toBeNull();
    corrupt()->expect(LaravelSentryHelpers::getName())->toBeNull();
});

it('can read version from composer.json', function () {
    composerJson()->expect(LaravelSentryHelpers::getVersion())->toBe('1.2.3.0');
});

it('can read name from composer.json', function () {
    composerJson()->expect(LaravelSentryHelpers::getName())->toBe('package-name');
});
it('can read full name from composer.json', function () {
    Config::set('sentry-helpers.omit_vendor_name', false);
    composerJson()->expect(LaravelSentryHelpers::getName())->toBe('package-vendor_package-name');
});

it('can read data from package.json', function () {
    Config::set('sentry-helpers.package_file', 'package.json');
    packageJson()->expect(LaravelSentryHelpers::getVersion())->toBe('1.2.3.0');
    packageJson()->expect(LaravelSentryHelpers::getName())->toBe('package-name');
});

it('sanitizes the package name', function () {
    foreach (["\n", "\t", '/', '\\'] as $char) {
        composerJson(name: sprintf('foo%1$sbar%1$sbaz', $char))->expect(LaravelSentryHelpers::getName())->not()->toContain($char);
        composerJson(name: sprintf('foo%1$sbar%1$sbaz', $char))->expect(LaravelSentryHelpers::getName())->toContain('_');
    }
});

it('generate proper release identifier', function () {
    composerJson()->expect(LaravelSentryHelpers::getRelease())->toBe('package-name@1.2.3.0');
});
