<?php

declare(strict_types=1);

namespace JustBetter\AkeneoProducts\Contracts\Akeneo;

interface FormatsAttributeValues
{
    public function format(string $attributeCode, mixed $value): array;
}
