<?php

namespace JustBetter\AkeneoProducts\Commands\Product;

use Illuminate\Console\Command;
use JustBetter\AkeneoProducts\Jobs\Product\ProcessProductsJob;

class ProcessProductsCommand extends Command
{
    protected $signature = 'akeneo-products:process';

    protected $description = 'Process products, retrieve or update products when pending.';

    public function handle(): int
    {
        ProcessProductsJob::dispatch();

        return static::SUCCESS;
    }
}
