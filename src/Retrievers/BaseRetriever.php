<?php

namespace JustBetter\AkeneoProducts\Retrievers;

use JustBetter\AkeneoProducts\Data\ProductData;

abstract class BaseRetriever
{
    abstract public function retrieve(string $identifier): ?ProductData;

    public static function current(): BaseRetriever
    {
        /** @var string $class */
        $class = config('akeneo-products.retriever');

        /** @var BaseRetriever $retriever */
        $retriever = app($class);

        return $retriever;
    }
}
