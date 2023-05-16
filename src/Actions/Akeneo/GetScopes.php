<?php

namespace JustBetter\AkeneoProducts\Actions\Akeneo;

use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;
use Illuminate\Support\Facades\Cache;
use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoProducts\Contracts\Akeneo\GetsScopes;
use JustBetter\AkeneoProducts\Data\ScopeData;

class GetScopes implements GetsScopes
{
    public function __construct(
        protected Akeneo $akeneo
    ) {
    }

    public function get(): Enumerable
    {
        $key = 'akeneo-products:scopes';
        $ttl = now()->addDay();

        $scopes = Cache::remember($key, $ttl, function (): array {
            $scopes = [];

            $resourceCursor = $this->akeneo->getChannelApi()->all();

            foreach ($resourceCursor as $scope) {
                $scopes[] = $scope;
            }

            return $scopes;
        });

        return (new Collection($scopes))->mapInto(ScopeData::class);
    }

    public static function bind(): void
    {
        app()->singleton(GetsScopes::class, static::class);
    }
}
