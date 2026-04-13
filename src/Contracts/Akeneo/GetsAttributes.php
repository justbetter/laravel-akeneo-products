<?php

declare(strict_types=1);

namespace JustBetter\AkeneoProducts\Contracts\Akeneo;

use JustBetter\AkeneoProducts\Data\AttributeData;

interface GetsAttributes
{
    public function get(string $code): AttributeData;
}
