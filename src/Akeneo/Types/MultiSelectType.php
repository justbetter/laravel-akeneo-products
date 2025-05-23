<?php

namespace JustBetter\AkeneoProducts\Akeneo\Types;

use JustBetter\AkeneoProducts\Contracts\Akeneo\ResolvesAttributeOptions;
use JustBetter\AkeneoProducts\Data\AttributeData;

class MultiSelectType extends BaseType
{
    public array $types = [
        'pim_catalog_multiselect',
    ];

    public function format(AttributeData $attributeData, mixed $value): ?array
    {
        if (is_array($value)) {
            [$code, $label] = $value;
        } else {
            $code = preg_replace('/([^A-Z0-9_]+)/i', '_', $value);
            $label = $value;
        }

        if (blank($code)) {
            return null;
        }

        /** @var ResolvesAttributeOptions $resolve */
        $resolve = app(ResolvesAttributeOptions::class);

        $option = $resolve->resolve($attributeData->code(), $code, $label);

        return [$option->code()];
    }
}
