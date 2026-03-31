<?php

declare(strict_types=1);

namespace JustBetter\AkeneoProducts\Contracts\Akeneo;

use JustBetter\AkeneoProducts\Data\AttributeOptionData;

interface CreatesAttributeOptions
{
    public function create(string $code, string $optionCode, array $data): AttributeOptionData;
}
