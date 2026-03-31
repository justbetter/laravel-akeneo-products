<?php

declare(strict_types=1);

namespace JustBetter\AkeneoProducts\Contracts\Product;

use JustBetter\AkeneoProducts\Models\Product;

interface UpdatesProduct
{
    public function update(Product $product): void;
}
