<?php

namespace JustBetter\AkeneoProducts\Akeneo\Types;

use JustBetter\AkeneoProducts\Data\AttributeData;

class MetricType extends BaseType
{
    public array $types = [
        'pim_catalog_metric',
    ];

    public function format(AttributeData $attributeData, mixed $value): array
    {
        if (is_array($value)) {
            [$amount, $unit] = $value;
        } else {
            $amount = $value;
            $unit = $attributeData['default_metric_unit'];
        }

        return [
            'amount' => $amount,
            'unit' => $unit,
        ];
    }
}
