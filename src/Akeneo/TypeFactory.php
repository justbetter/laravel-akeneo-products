<?php

namespace JustBetter\AkeneoProducts\Akeneo;

use JustBetter\AkeneoProducts\Akeneo\Types\BaseType;
use JustBetter\AkeneoProducts\Akeneo\Types\BooleanType;
use JustBetter\AkeneoProducts\Akeneo\Types\MetricType;
use JustBetter\AkeneoProducts\Akeneo\Types\NumberType;
use JustBetter\AkeneoProducts\Akeneo\Types\PriceCollectionType;
use JustBetter\AkeneoProducts\Akeneo\Types\SimpleSelectType;
use JustBetter\AkeneoProducts\Akeneo\Types\SimpleType;
use JustBetter\AkeneoProducts\Exceptions\InvalidTypeException;

class TypeFactory
{
    public array $types = [
        SimpleType::class,
        BooleanType::class,
        SimpleSelectType::class,
        MetricType::class,
        NumberType::class,
        PriceCollectionType::class,
    ];

    public function for(string $type): BaseType
    {
        /** @var ?BaseType $baseType */
        $baseType = collect($this->types)
            ->map(fn (string $class): BaseType => app($class))
            ->filter(fn (BaseType $baseType): bool => $baseType->matches($type))
            ->first();

        if ($baseType === null) {
            throw new InvalidTypeException('Type "'.$type.'" is unsupported');
        }

        return $baseType;
    }
}
