<?php

namespace JustBetter\AkeneoProducts\Actions\ProductModel;

use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoProducts\Contracts\ProductModel\UpdatesProductModel;
use JustBetter\AkeneoProducts\Models\ProductModel;

class UpdateProductModel implements UpdatesProductModel
{
    public function __construct(
        protected Akeneo $akeneo
    ) {
    }

    public function update(ProductModel $productModel): void
    {
        $data = $productModel->data;

        unset($data['code']);

        $this->akeneo->getProductModelApi()->upsert($productModel->code, $data);

        $productModel->modified_at = now();
        $productModel->update = false;
        $productModel->save();
    }

    public static function bind(): void
    {
        app()->singleton(UpdatesProductModel::class, static::class);
    }
}
