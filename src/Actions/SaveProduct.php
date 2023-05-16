<?php

namespace JustBetter\AkeneoProducts\Actions;

use JustBetter\AkeneoProducts\Contracts\SavesProduct;
use JustBetter\AkeneoProducts\Data\ProductData;
use JustBetter\AkeneoProducts\Models\Product;

class SaveProduct implements SavesProduct
{
    public function save(ProductData $productData): void
    {
        /** @var Product $product */
        $product = Product::query()->firstOrCreate(
            [
                'identifier' => $productData->identifier(),
            ],
            [
                'data' => [],
            ],
        );

        $data = $productData->toArray();

        $encoded = json_encode($data);

        $product->data = $data;
        $product->checksum = md5($encoded ?: '');
        $product->retrieved_at = now();
        $product->retrieve = false;

        if (! $product->update) {
            $product->update = $product->isDirty(['checksum']);
        }

        $product->save();
    }

    public static function bind(): void
    {
        app()->singleton(SavesProduct::class, static::class);
    }
}
