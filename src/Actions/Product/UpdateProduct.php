<?php

namespace JustBetter\AkeneoProducts\Actions\Product;

use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoProducts\Contracts\Product\UpdatesProduct;
use JustBetter\AkeneoProducts\Models\Product;

class UpdateProduct implements UpdatesProduct
{
    public function __construct(
        protected Akeneo $akeneo
    ) {}

    public function update(Product $product): void
    {
        $this->akeneo->getProductApi()->upsert($product->identifier, $product->data);

        $product->modified_at = now();
        $product->update = false;
        $product->fail_count = 0;
        $product->failed_at = null;
        $product->resetFailures();
        $product->save();
    }

    public static function bind(): void
    {
        app()->singleton(UpdatesProduct::class, static::class);
    }
}
