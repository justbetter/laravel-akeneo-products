<?php

namespace JustBetter\AkeneoProducts\Actions\Akeneo;

use Illuminate\Support\Facades\Cache;
use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoProducts\Contracts\Akeneo\GetsAttributes;
use JustBetter\AkeneoProducts\Data\AttributeData;

class GetAttribute implements GetsAttributes
{
    public function __construct(
        protected Akeneo $akeneo
    ) {
    }

    public function get(string $code): AttributeData
    {
        $key = "akeneo-products:attribute:$code";
        $ttl = now()->addDay();

        $data = Cache::remember($key, $ttl, fn (): array => $this->akeneo->getAttributeApi()->get($code));

        return AttributeData::of($data);
    }

    public static function bind(): void
    {
        app()->singleton(GetsAttributes::class, static::class);
    }
}
