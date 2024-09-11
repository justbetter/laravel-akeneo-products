<?php

namespace JustBetter\AkeneoProducts\Actions\Akeneo;

use Illuminate\Support\Facades\Cache;
use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoProducts\Contracts\Akeneo\CreatesAttributeOptions;
use JustBetter\AkeneoProducts\Contracts\Akeneo\GetsAttributeOptions;
use JustBetter\AkeneoProducts\Data\AttributeOptionData;

class CreateAttributeOption implements CreatesAttributeOptions
{
    public function __construct(
        protected Akeneo $akeneo,
        protected GetsAttributeOptions $getsAttributeOptions
    ) {}

    public function create(string $code, string $optionCode, array $data): AttributeOptionData
    {
        // Forget the attribute options for the given attribute te fetch the newly created options afterwards.
        Cache::forget(GetAttributeOptions::cacheKey($code));

        $this->akeneo->getAttributeOptionApi()->create($code, $optionCode, $data);

        return $this->getsAttributeOptions
            ->get($code)
            ->firstOrFail(fn (AttributeOptionData $option): bool => $option->code() === $optionCode);
    }

    public static function bind(): void
    {
        app()->singleton(CreatesAttributeOptions::class, static::class);
    }
}
