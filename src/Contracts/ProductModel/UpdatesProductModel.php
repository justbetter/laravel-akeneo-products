<?php

declare(strict_types=1);

namespace JustBetter\AkeneoProducts\Contracts\ProductModel;

use JustBetter\AkeneoProducts\Models\ProductModel;

interface UpdatesProductModel
{
    public function update(ProductModel $productModel): void;
}
