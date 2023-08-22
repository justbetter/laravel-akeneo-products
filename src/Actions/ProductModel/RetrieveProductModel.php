<?php

namespace JustBetter\AkeneoProducts\Actions\ProductModel;

use JustBetter\AkeneoProducts\Contracts\ProductModel\RetrievesProductModel;
use JustBetter\AkeneoProducts\Jobs\ProductModel\SaveProductModelJob;
use JustBetter\AkeneoProducts\Retrievers\ProductModel\BaseProductModelRetriever;

class RetrieveProductModel implements RetrievesProductModel
{
    public function retrieve(string $code): void
    {
        $productModel = BaseProductModelRetriever::current()->retrieve($code);

        if ($productModel !== null) {
            SaveProductModelJob::dispatch($productModel);
        }
    }

    public static function bind(): void
    {
        app()->singleton(RetrievesProductModel::class, static::class);
    }
}
