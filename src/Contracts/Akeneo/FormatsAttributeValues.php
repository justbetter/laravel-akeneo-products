<?php

namespace JustBetter\AkeneoProducts\Contracts\Akeneo;

interface FormatsAttributeValues
{
    public function format(string $attributeCode, mixed $value): array;
}
