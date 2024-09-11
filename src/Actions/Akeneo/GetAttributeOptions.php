<?php

namespace JustBetter\AkeneoProducts\Actions\Akeneo;

use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;
use Illuminate\Support\Facades\Cache;
use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoProducts\Contracts\Akeneo\GetsAttributeOptions;
use JustBetter\AkeneoProducts\Data\AttributeOptionData;

class GetAttributeOptions implements GetsAttributeOptions
{
    public function __construct(
        protected Akeneo $akeneo
    ) {}

    public function get(string $code): Enumerable
    {
        $ttl = now()->addDay();

        $data = Cache::remember(static::cacheKey($code), $ttl, function () use ($code): array {
            $options = [];

            $resourceCursor = $this->akeneo->getAttributeOptionApi()->all($code, 100);

            foreach ($resourceCursor as $option) {
                $options[] = $option;
            }

            return $options;
        });

        return (new Collection($data))->mapInto(AttributeOptionData::class);
    }

    public static function cacheKey(string $code): string
    {
        return "akeneo-products:attribute-options:$code";
    }

    public static function bind(): void
    {
        app()->singleton(GetsAttributeOptions::class, static::class);
    }
}
