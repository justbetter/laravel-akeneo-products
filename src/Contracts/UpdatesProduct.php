<?php

namespace JustBetter\AkeneoProducts\Contracts;

use JustBetter\AkeneoProducts\Models\Product;

interface UpdatesProduct
{
    public function update(Product $product): void;
}
