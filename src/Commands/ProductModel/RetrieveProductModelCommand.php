<?php

namespace JustBetter\AkeneoProducts\Commands\ProductModel;

use Illuminate\Console\Command;
use JustBetter\AkeneoProducts\Jobs\ProductModel\RetrieveProductModelJob;

class RetrieveProductModelCommand extends Command
{
    protected $signature = 'akeneo-products:model:retrieve {code}';

    protected $description = 'Retrieve a product model by its code';

    public function handle(): int
    {
        /** @var string $code */
        $code = $this->argument('code');

        RetrieveProductModelJob::dispatch($code);

        return static::SUCCESS;
    }
}
