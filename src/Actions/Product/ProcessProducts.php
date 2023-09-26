<?php

namespace JustBetter\AkeneoProducts\Actions\Product;

use JustBetter\AkeneoProducts\Contracts\Product\ProcessesProducts;
use JustBetter\AkeneoProducts\Jobs\Product\RetrieveProductJob;
use JustBetter\AkeneoProducts\Jobs\Product\UpdateProductJob;
use JustBetter\AkeneoProducts\Models\Product;
use JustBetter\AkeneoProducts\Retrievers\Product\BaseProductRetriever;

class ProcessProducts implements ProcessesProducts
{
    public function process(): void
    {
        // If the product has to be retrieved again, reset the update state.
        Product::query()
            ->where('retrieve', '=', true)
            ->where('update', '=', true)
            ->update(['update' => false]);

        $retrieveBatchSize = BaseProductRetriever::current()->retrieveBatchSize();

        // Dispatch jobs for all products that should be retrieved.
        Product::query()
            ->scopes('shouldRetrieve')
            ->limit($retrieveBatchSize)
            ->get()
            ->pluck('identifier')
            ->each(fn (string $identifier) => RetrieveProductJob::dispatch($identifier));

        $updateBatchSize = BaseProductRetriever::current()->updateBatchSize();

        // Dispatch jobs for all products that are should be updated.
        Product::query()
            ->scopes('shouldUpdate')
            ->limit($updateBatchSize)
            ->get()
            ->each(fn (Product $product) => UpdateProductJob::dispatch($product));
    }

    public static function bind(): void
    {
        app()->singleton(ProcessesProducts::class, static::class);
    }
}
