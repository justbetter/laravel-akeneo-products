<?php

declare(strict_types=1);

namespace JustBetter\AkeneoProducts\Contracts\Akeneo;

use Illuminate\Support\Enumerable;
use JustBetter\AkeneoProducts\Data\AttributeOptionData;

interface GetsAttributeOptions
{
    /** @return Enumerable<int, AttributeOptionData> */
    public function get(string $code): Enumerable;
}
