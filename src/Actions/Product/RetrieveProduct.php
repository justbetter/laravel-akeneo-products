<?php

namespace JustBetter\AkeneoProducts\Actions\Product;

use JustBetter\AkeneoProducts\Contracts\Product\RetrievesProduct;
use JustBetter\AkeneoProducts\Jobs\Product\SaveProductJob;
use JustBetter\AkeneoProducts\Retrievers\Product\BaseProductRetriever;

class RetrieveProduct implements RetrievesProduct
{
    public function retrieve(string $identifier): void
    {
        $product = BaseProductRetriever::current()->retrieve($identifier);

        if ($product !== null) {
            SaveProductJob::dispatch($product);
        }
    }

    public static function bind(): void
    {
        app()->singleton(RetrievesProduct::class, static::class);
    }
}
