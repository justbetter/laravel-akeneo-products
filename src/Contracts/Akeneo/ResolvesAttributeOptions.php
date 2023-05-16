<?php

namespace JustBetter\AkeneoProducts\Contracts\Akeneo;

use JustBetter\AkeneoProducts\Data\AttributeOptionData;

interface ResolvesAttributeOptions
{
    public function resolve(string $code, string $optionCode, string $label): AttributeOptionData;
}
