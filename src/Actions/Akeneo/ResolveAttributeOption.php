<?php

namespace JustBetter\AkeneoProducts\Actions\Akeneo;

use JustBetter\AkeneoProducts\Contracts\Akeneo\CreatesAttributeOptions;
use JustBetter\AkeneoProducts\Contracts\Akeneo\GetsAttributeOptions;
use JustBetter\AkeneoProducts\Contracts\Akeneo\GetsLocales;
use JustBetter\AkeneoProducts\Contracts\Akeneo\ResolvesAttributeOptions;
use JustBetter\AkeneoProducts\Data\AttributeOptionData;
use JustBetter\AkeneoProducts\Data\LocaleData;

class ResolveAttributeOption implements ResolvesAttributeOptions
{
    public function __construct(
        protected GetsAttributeOptions $getsAttributeOptions,
        protected GetsLocales $getsLocales,
        protected CreatesAttributeOptions $createsAttributeOptions
    ) {
    }

    public function resolve(string $code, string $optionCode, string $label): AttributeOptionData
    {
        $options = $this->getsAttributeOptions->get($code);

        $currentOption = $options->first(function (AttributeOptionData $data) use ($optionCode): bool {
            return strtolower($data->code()) === strtolower($optionCode);
        });

        if ($currentOption !== null) {
            return $currentOption;
        }

        foreach ($options as $option) {
            foreach ($option->labels() as $optionLabel) {
                if (strtolower($label) === strtolower($optionLabel)) {
                    return $option;
                }
            }
        }

        $labels = $this->getsLocales
            ->get()
            ->mapWithKeys(fn (LocaleData $locale): array => [$locale->code() => $label])
            ->toArray();

        return $this->createsAttributeOptions->create($code, $optionCode, [
            'labels' => $labels,
        ]);
    }

    public static function bind(): void
    {
        app()->singleton(ResolvesAttributeOptions::class, static::class);
    }
}
