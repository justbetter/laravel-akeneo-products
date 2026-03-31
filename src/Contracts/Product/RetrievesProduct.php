<?php

declare(strict_types=1);

namespace JustBetter\AkeneoProducts\Contracts\Product;

interface RetrievesProduct
{
    public function retrieve(string $identifier): void;
}
