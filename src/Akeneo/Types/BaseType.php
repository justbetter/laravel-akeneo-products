<?php

namespace JustBetter\AkeneoProducts\Akeneo\Types;

use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoProducts\Data\AttributeData;

abstract class BaseType
{
    public array $types = [
        //
    ];

    public function __construct(
        protected Akeneo $akeneo
    ) {}

    public function matches(string $type): bool
    {
        return in_array($type, $this->types);
    }

    abstract public function format(AttributeData $attributeData, mixed $value): mixed;
}
