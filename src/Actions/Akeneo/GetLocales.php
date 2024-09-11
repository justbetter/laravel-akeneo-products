<?php

namespace JustBetter\AkeneoProducts\Actions\Akeneo;

use Akeneo\Pim\ApiClient\Search\SearchBuilder;
use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;
use Illuminate\Support\Facades\Cache;
use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoProducts\Contracts\Akeneo\GetsLocales;
use JustBetter\AkeneoProducts\Data\LocaleData;

class GetLocales implements GetsLocales
{
    public function __construct(
        protected Akeneo $akeneo
    ) {}

    public function get(): Enumerable
    {
        $key = 'akeneo-products:locales';
        $ttl = now()->addDay();

        $locales = Cache::remember($key, $ttl, function (): array {
            $search = new SearchBuilder;
            $search->addFilter('enabled', '=', true);

            $locales = [];

            $resourceCursor = $this->akeneo->getLocaleApi()->all(100, [
                'search' => $search->getFilters(),
            ]);

            foreach ($resourceCursor as $locale) {
                $locales[] = $locale;
            }

            return $locales;
        });

        return (new Collection($locales))->mapInto(LocaleData::class);
    }

    public static function bind(): void
    {
        app()->singleton(GetsLocales::class, static::class);
    }
}
