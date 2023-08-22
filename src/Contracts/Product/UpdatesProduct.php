<?php

namespace JustBetter\AkeneoProducts\Contracts\Product;

use JustBetter\AkeneoProducts\Models\Product;

interface UpdatesProduct
{
    public function update(Product $product): void;
}
