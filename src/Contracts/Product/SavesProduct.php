<?php

namespace JustBetter\AkeneoProducts\Contracts\Product;

use JustBetter\AkeneoProducts\Data\ProductData;

interface SavesProduct
{
    public function save(ProductData $productData): void;
}
