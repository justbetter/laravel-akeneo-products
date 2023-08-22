<?php

namespace JustBetter\AkeneoProducts\Commands\ProductModel;

use Illuminate\Console\Command;
use JustBetter\AkeneoProducts\Jobs\ProductModel\UpdateProductModelJob;
use JustBetter\AkeneoProducts\Models\ProductModel;

class UpdateProductModelCommand extends Command
{
    protected $signature = 'akeneo-products:model:update {code}';

    protected $description = 'Update a product model by its code';

    public function handle(): int
    {
        /** @var string $code */
        $code = $this->argument('code');

        /** @var ProductModel $productModel */
        $productModel = ProductModel::query()
            ->where('code', '=', $code)
            ->firstOrFail();

        UpdateProductModelJob::dispatch($productModel);

        return static::SUCCESS;
    }
}
