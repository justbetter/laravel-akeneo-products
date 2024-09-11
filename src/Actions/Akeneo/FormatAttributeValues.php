<?php

namespace JustBetter\AkeneoProducts\Actions\Akeneo;

use JustBetter\AkeneoProducts\Akeneo\TypeFactory;
use JustBetter\AkeneoProducts\Contracts\Akeneo\FormatsAttributeValues;
use JustBetter\AkeneoProducts\Contracts\Akeneo\GetsAttributes;
use JustBetter\AkeneoProducts\Contracts\Akeneo\GetsLocales;
use JustBetter\AkeneoProducts\Contracts\Akeneo\GetsScopes;

/** Formats the data value of an attribute */
class FormatAttributeValues implements FormatsAttributeValues
{
    public function __construct(
        protected GetsAttributes $getsAttributes,
        protected TypeFactory $typeFactory,
        protected GetsScopes $getsScopes,
        protected GetsLocales $getsLocales
    ) {}

    public function format(string $attributeCode, mixed $value): array
    {
        $attribute = $this->getsAttributes->get($attributeCode);

        $type = $this->typeFactory->for($attribute->type());

        $data = $type->format($attribute, $value);

        $values = [];

        $scopes = $this->getsScopes->get();
        $locales = $this->getsLocales->get();

        if ($attribute->scopable()) {
            foreach ($scopes as $scope) {
                if (! $attribute->localizable()) {
                    $values[] = $this->value($data, $scope->code());

                    continue;
                }

                foreach ($scope->locales() as $locale) {
                    $values[] = $this->value($data, $scope->code(), $locale);
                }
            }
        } else {
            if (! $attribute->localizable()) {
                $values[] = $this->value($data);
            } else {
                foreach ($locales as $locale) {
                    $values[] = $this->value($data, null, $locale->code());
                }
            }
        }

        return $values;
    }

    public function value(mixed $data, ?string $scope = null, ?string $locale = null): array
    {
        return [
            'data' => $data,
            'scope' => $scope,
            'locale' => $locale,
        ];
    }

    public static function bind(): void
    {
        app()->singleton(FormatsAttributeValues::class, static::class);
    }
}
