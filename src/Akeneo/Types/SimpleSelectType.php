<?php

declare(strict_types=1);

namespace JustBetter\AkeneoProducts\Akeneo\Types;

use JustBetter\AkeneoProducts\Contracts\Akeneo\ResolvesAttributeOptions;
use JustBetter\AkeneoProducts\Data\AttributeData;

class SimpleSelectType extends BaseType
{
    public array $types = [
        'pim_catalog_simpleselect',
    ];

    public function format(AttributeData $attributeData, mixed $value): ?string
    {
        if (is_array($value)) {
            [$code, $label] = $value;
        } else {
            $code = preg_replace('/([^A-Z0-9_]+)/i', '_', (string) $value);
            $label = $value;
        }

        if (blank($code)) {
            return null;
        }

        /** @var ResolvesAttributeOptions $resolve */
        $resolve = app(ResolvesAttributeOptions::class);

        $option = $resolve->resolve($attributeData->code(), $code, $label);

        return $option->code();
    }
}
