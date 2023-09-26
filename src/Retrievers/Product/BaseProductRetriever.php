<?php

namespace JustBetter\AkeneoProducts\Retrievers\Product;

use JustBetter\AkeneoProducts\Data\ProductData;
use JustBetter\AkeneoProducts\Retrievers\BaseRetriever;

abstract class BaseProductRetriever extends BaseRetriever
{
    abstract public function retrieve(string $identifier): ?ProductData;

    public static function current(): static
    {
        /** @var string $class */
        $class = config('akeneo-products.retrievers.product');

        /** @var static $retriever */
        $retriever = app($class);

        return $retriever;
    }
}
