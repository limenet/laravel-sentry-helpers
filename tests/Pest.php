<?php

use Limenet\LaravelSentryHelpers\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

function packageJson($version = '1.2.3', $name = 'package-name')
{
    file_put_contents(
        base_path('package.json'),
        json_encode(array_filter([
            'version' => $version,
            'name' => $name,
        ]))
    );

    return test();
}
function composerJson($version = '1.2.3', $name = 'package-vendor/package-name')
{
    file_put_contents(
        base_path('composer.json'),
        json_encode(array_filter([
            'version' => $version,
            'name' => $name,
        ]))
    );

    return test();
}

function corrupt()
{
    file_put_contents(
        base_path('package.json'),
        '{'
    );

    return test();
}
