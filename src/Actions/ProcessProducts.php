<?php

namespace JustBetter\AkeneoProducts\Actions;

use JustBetter\AkeneoProducts\Contracts\ProcessesProducts;
use JustBetter\AkeneoProducts\Jobs\RetrieveProductJob;
use JustBetter\AkeneoProducts\Jobs\UpdateProductJob;
use JustBetter\AkeneoProducts\Models\Product;

class ProcessProducts implements ProcessesProducts
{
    public function process(): void
    {
        // If the product has to be retrieved again, reset the update state.
        Product::query()
            ->where('retrieve', '=', true)
            ->where('update', '=', true)
            ->update(['update' => false]);

        /** @var int $retrieveBatchSize */
        $retrieveBatchSize = config('akeneo-products.retrieve_batch_size');

        // Dispatch jobs for all products that should be retrieved.
        Product::query()
            ->scopes('shouldRetrieve')
            ->limit($retrieveBatchSize)
            ->get()
            ->pluck('identifier')
            ->each(fn (string $identifier) => RetrieveProductJob::dispatch($identifier));

        /** @var int $updateBatchSize */
        $updateBatchSize = config('akeneo-products.update_batch_size');

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
