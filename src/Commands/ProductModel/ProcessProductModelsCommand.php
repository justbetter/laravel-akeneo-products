<?php

namespace JustBetter\AkeneoProducts\Commands\ProductModel;

use Illuminate\Console\Command;
use JustBetter\AkeneoProducts\Jobs\ProductModel\ProcessProductModelsJob;

class ProcessProductModelsCommand extends Command
{
    protected $signature = 'akeneo-products:model:process';

    protected $description = 'Process product models, retrieve or update product models when pending.';

    public function handle(): int
    {
        ProcessProductModelsJob::dispatch();

        return static::SUCCESS;
    }
}
