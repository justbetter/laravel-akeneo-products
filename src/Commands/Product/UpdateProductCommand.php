<?php

namespace JustBetter\AkeneoProducts\Commands\Product;

use Illuminate\Console\Command;
use JustBetter\AkeneoProducts\Jobs\Product\UpdateProductJob;
use JustBetter\AkeneoProducts\Models\Product;

class UpdateProductCommand extends Command
{
    protected $signature = 'akeneo-products:update {identifier}';

    protected $description = 'Update a product by its identifier';

    public function handle(): int
    {
        /** @var string $identifier */
        $identifier = $this->argument('identifier');

        /** @var Product $product */
        $product = Product::query()
            ->where('identifier', '=', $identifier)
            ->firstOrFail();

        UpdateProductJob::dispatch($product);

        return static::SUCCESS;
    }
}
