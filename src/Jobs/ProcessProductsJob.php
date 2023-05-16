<?php

namespace JustBetter\AkeneoProducts\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use JustBetter\AkeneoProducts\Contracts\ProcessesProducts;

class ProcessProductsJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct()
    {
        $this->onQueue(config('akeneo-products.queue'));
    }

    public function handle(ProcessesProducts $processesProducts): void
    {
        $processesProducts->process();
    }
}
