<?php

namespace JustBetter\AkeneoProducts\Retrievers\ProductModel;

use JustBetter\AkeneoProducts\Data\ProductModelData;
use JustBetter\AkeneoProducts\Retrievers\BaseRetriever;

abstract class BaseProductModelRetriever extends BaseRetriever
{
    abstract public function retrieve(string $code): ?ProductModelData;

    public static function current(): static
    {
        /** @var string $class */
        $class = config('akeneo-products.retrievers.product_model');

        /** @var static $retriever */
        $retriever = app($class);

        return $retriever;
    }
}
