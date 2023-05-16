<?php

namespace JustBetter\AkeneoProducts\Akeneo\Types;

use JustBetter\AkeneoProducts\Data\AttributeData;

class BooleanType extends BaseType
{
    public array $types = [
        'pim_catalog_boolean',
    ];

    public function format(AttributeData $attributeData, mixed $value): bool
    {
        return (bool) $value;
    }
}
