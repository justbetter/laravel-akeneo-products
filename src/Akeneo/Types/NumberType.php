<?php

namespace JustBetter\AkeneoProducts\Akeneo\Types;

use JustBetter\AkeneoProducts\Data\AttributeData;
use JustBetter\AkeneoProducts\Exceptions\InvalidValueException;

class NumberType extends BaseType
{
    public array $types = [
        'pim_catalog_number',
    ];

    public function format(AttributeData $attributeData, mixed $value): float|int
    {
        if (! is_numeric($value)) {
            throw new InvalidValueException($attributeData->code(), $value);
        }

        return $attributeData['decimals_allowed']
            ? floatval($value)
            : intval($value);
    }
}
