<?php

namespace JustBetter\AkeneoProducts\Commands;

use Illuminate\Console\Command;
use JustBetter\AkeneoProducts\Jobs\ProcessProductsJob;

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
