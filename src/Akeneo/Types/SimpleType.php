<?php

namespace JustBetter\AkeneoProducts\Akeneo\Types;

use JustBetter\AkeneoProducts\Data\AttributeData;

class SimpleType extends BaseType
{
    public array $types = [
        'pim_catalog_text',
        'pim_catalog_textarea',
    ];

    public function format(AttributeData $attributeData, mixed $value): string
    {
        return $value;
    }
}
