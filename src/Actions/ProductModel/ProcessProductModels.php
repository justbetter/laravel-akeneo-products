<?php

namespace JustBetter\AkeneoProducts\Actions\ProductModel;

use JustBetter\AkeneoProducts\Contracts\ProductModel\ProcessesProductModels;
use JustBetter\AkeneoProducts\Jobs\ProductModel\RetrieveProductModelJob;
use JustBetter\AkeneoProducts\Jobs\ProductModel\UpdateProductModelJob;
use JustBetter\AkeneoProducts\Models\ProductModel;
use JustBetter\AkeneoProducts\Retrievers\ProductModel\BaseProductModelRetriever;

class ProcessProductModels implements ProcessesProductModels
{
    public function process(): void
    {
        // If the product model has to be retrieved again, reset the update state.
        ProductModel::query()
            ->where('retrieve', '=', true)
            ->where('update', '=', true)
            ->update(['update' => false]);

        $retrieveBatchSize = BaseProductModelRetriever::current()->retrieveBatchSize();

        // Dispatch jobs for all product models that should be retrieved.
        ProductModel::query()
            ->scopes('shouldRetrieve')
            ->limit($retrieveBatchSize)
            ->get()
            ->pluck('code')
            ->each(fn (string $code) => RetrieveProductModelJob::dispatch($code));

        $updateBatchSize = BaseProductModelRetriever::current()->updateBatchSize();

        // Dispatch jobs for all product models that are should be updated.
        ProductModel::query()
            ->scopes('shouldUpdate')
            ->limit($updateBatchSize)
            ->get()
            ->each(fn (ProductModel $productModel) => UpdateProductModelJob::dispatch($productModel));
    }

    public static function bind(): void
    {
        app()->singleton(ProcessesProductModels::class, static::class);
    }
}
