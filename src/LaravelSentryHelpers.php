<?php

namespace Limenet\LaravelSentryHelpers;

use Composer\Semver\VersionParser;
use Illuminate\Support\Arr;
use JsonException;
use UnexpectedValueException;

class LaravelSentryHelpers
{
    public function getVersion(): ?string
    {
        $version = Arr::get($this->getPackageContents(), 'version', null);

        if ($version === null) {
            return null;
        }

        try {
            $version = (new VersionParser())->normalize($version);
        } catch (UnexpectedValueException $e) {
            return null;
        }

        return$version;
    }

    public function getName(): ?string
    {
        $name = Arr::get($this->getPackageContents(), 'name', null);

        if ($name === null) {
            return null;
        }

        if (config('sentry-helpers.omit_vendor_name') && str_contains($name, '/')) {
            $name = explode('/', $name, 2)[1];
        }

        return str_replace(["\n","\t",'/','\\'], '_', $name);
    }

    public function getRelease(): ?string
    {
        $version = $this->getVersion();
        $name = $this->getName();

        if ($version === null || $name === null) {
            return null;
        }

        return sprintf('%s@%s', $name, $version);
    }

    /** @return array<mixed> */
    private function getPackageContents(): array
    {
        try {
            $contents = rescue(
                fn (): array => json_decode(file_get_contents($this->getPackageFilePath()) ?: '', true, 10, JSON_THROW_ON_ERROR),
                []
            );
        } catch (JsonException $e) {
            $contents = [];
        }


        return $contents;
    }

    private function getPackageFilePath(): string
    {
        return base_path(config('sentry-helpers.package_file'));
    }

    public function getCacheTtlInSeconds(): ?int
    {
        return config('sentry-helpers.cache_ttl_in_seconds');
    }

    public function getCacheKey(): string
    {
        return __METHOD__;
    }
}
