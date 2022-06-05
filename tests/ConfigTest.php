<?php

it('has no changed defaults', function () {
    expect(config('sentry-helpers.package_file'))->toBe('composer.json');
    expect(config('sentry-helpers.cache_ttl_in_seconds'))->toBeNull();
    expect(config('sentry-helpers.omit_vendor_name'))->toBeTrue();
});
