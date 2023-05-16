<?php

namespace JustBetter\AkeneoProducts\Contracts\Akeneo;

use Illuminate\Support\Enumerable;
use JustBetter\AkeneoProducts\Data\LocaleData;

interface GetsLocales
{
    /** @return Enumerable<int, LocaleData> */
    public function get(): Enumerable;
}
