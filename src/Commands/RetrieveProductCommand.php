<?php

namespace JustBetter\AkeneoProducts\Commands;

use Illuminate\Console\Command;
use JustBetter\AkeneoProducts\Jobs\RetrieveProductJob;

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
