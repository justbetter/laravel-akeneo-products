<?php

namespace JustBetter\AkeneoProducts\Actions;

use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoProducts\Contracts\UpdatesProduct;
use JustBetter\AkeneoProducts\Models\Product;

class UpdateProduct implements UpdatesProduct
{
    public function __construct(
        protected Akeneo $akeneo
    ) {
    }

    public function update(Product $product): void
    {
        $this->akeneo->getProductApi()->upsert($product->identifier, $product->data);

        $product->modified_at = now();
        $product->update = false;
        $product->save();
    }

    public static function bind(): void
    {
        app()->singleton(UpdatesProduct::class, static::class);
    }
}
