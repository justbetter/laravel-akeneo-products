<?php

declare(strict_types=1);

namespace JustBetter\AkeneoProducts\Contracts\Akeneo;

use Illuminate\Support\Enumerable;
use JustBetter\AkeneoProducts\Data\ScopeData;

interface GetsScopes
{
    /** @return Enumerable<int, ScopeData> */
    public function get(): Enumerable;
}
