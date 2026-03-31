<?php

declare(strict_types=1);

namespace JustBetter\AkeneoProducts\Contracts\ProductModel;

use JustBetter\AkeneoProducts\Data\ProductModelData;

interface SavesProductModel
{
    public function save(ProductModelData $productModelData): void;
}
