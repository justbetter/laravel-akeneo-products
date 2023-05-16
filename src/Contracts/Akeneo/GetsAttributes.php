<?php

namespace JustBetter\AkeneoProducts\Contracts\Akeneo;

use JustBetter\AkeneoProducts\Data\AttributeData;

interface GetsAttributes
{
    public function get(string $code): AttributeData;
}
