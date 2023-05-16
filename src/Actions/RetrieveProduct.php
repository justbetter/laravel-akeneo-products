<?php

namespace JustBetter\AkeneoProducts\Actions;

use JustBetter\AkeneoProducts\Contracts\RetrievesProduct;
use JustBetter\AkeneoProducts\Jobs\SaveProductJob;
use JustBetter\AkeneoProducts\Retrievers\BaseRetriever;

class RetrieveProduct implements RetrievesProduct
{
    public function retrieve(string $identifier): void
    {
        $product = BaseRetriever::current()->retrieve($identifier);

        if ($product !== null) {
            SaveProductJob::dispatch($product);
        }
    }

    public static function bind(): void
    {
        app()->singleton(RetrievesProduct::class, static::class);
    }
}
