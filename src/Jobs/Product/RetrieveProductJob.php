<?php

namespace JustBetter\AkeneoProducts\Jobs\Product;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use JustBetter\AkeneoProducts\Contracts\Product\RetrievesProduct;

class RetrieveProductJob implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(
        public string $identifier
    ) {
        $this->onQueue(config('akeneo-products.queue'));
    }

    public function handle(RetrievesProduct $retrievesProduct): void
    {
        $retrievesProduct->retrieve($this->identifier);
    }

    public function uniqueId(): string
    {
        return $this->identifier;
    }

    public function tags(): array
    {
        return [
            $this->identifier,
        ];
    }
}
