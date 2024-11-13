<?php

namespace JustBetter\AkeneoProducts\Akeneo\Types;

use JustBetter\AkeneoProducts\Data\AttributeData;
use JustBetter\AkeneoProducts\Exceptions\InvalidValueException;

class PriceCollectionType extends BaseType
{
    const DEFAULT_CURRENCY = 'EUR';

    public array $types = [
        'pim_catalog_price_collection',
    ];

    public function format(AttributeData $attributeData, mixed $value): array
    {
        if (is_string($value) || is_numeric($value)) {
            $amount = $value;
            $currency = static::DEFAULT_CURRENCY;
        }

        if (is_array($value)) {
            [$amount, $currency] = $value;
        }

        if (! isset($amount) || ! isset($currency)) {
            throw new InvalidValueException($attributeData->code(), $value);
        }

        return [
            [
                'amount' => $amount,
                'currency' => $currency,
            ],
        ];
    }
}
