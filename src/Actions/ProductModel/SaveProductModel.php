<?php

namespace JustBetter\AkeneoProducts\Actions\ProductModel;

use JustBetter\AkeneoProducts\Contracts\ProductModel\SavesProductModel;
use JustBetter\AkeneoProducts\Data\ProductModelData;
use JustBetter\AkeneoProducts\Models\ProductModel;

class SaveProductModel implements SavesProductModel
{
    public function save(ProductModelData $productModelData): void
    {
        /** @var ProductModel $productModel */
        $productModel = ProductModel::query()->firstOrCreate(
            [
                'code' => $productModelData->code(),
            ],
            [
                'data' => [],
            ],
        );

        $data = $productModelData->toArray();

        $encoded = json_encode($data);

        $productModel->data = $data;
        $productModel->checksum = md5($encoded ?: '');
        $productModel->retrieved_at = now();
        $productModel->retrieve = false;

        if (! $productModel->update) {
            $productModel->update = $productModel->isDirty(['checksum']);
        }

        $productModel->save();
    }

    public static function bind(): void
    {
        app()->singleton(SavesProductModel::class, static::class);
    }
}
