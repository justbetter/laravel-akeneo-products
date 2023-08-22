<?php

namespace JustBetter\AkeneoProducts\Contracts\Product;

interface RetrievesProduct
{
    public function retrieve(string $identifier): void;
}
