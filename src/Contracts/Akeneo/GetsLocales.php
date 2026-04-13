<?php

declare(strict_types=1);

namespace JustBetter\AkeneoProducts\Contracts\Akeneo;

use Illuminate\Support\Enumerable;
use JustBetter\AkeneoProducts\Data\LocaleData;

interface GetsLocales
{
    /** @return Enumerable<int, LocaleData> */
    public function get(): Enumerable;
}
