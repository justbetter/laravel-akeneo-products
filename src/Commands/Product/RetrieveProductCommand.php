<?php

namespace JustBetter\AkeneoProducts\Commands\Product;

use Illuminate\Console\Command;
use JustBetter\AkeneoProducts\Jobs\Product\RetrieveProductJob;

class RetrieveProductCommand extends Command
{
    protected $signature = 'akeneo-products:retrieve {identifier}';

    protected $description = 'Retrieve a product by its identifier';

    public function handle(): int
    {
        /** @var string $identifier */
        $identifier = $this->argument('identifier');

        RetrieveProductJob::dispatch($identifier);

        return static::SUCCESS;
    }
}
