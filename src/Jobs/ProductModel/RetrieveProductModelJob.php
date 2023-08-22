<?php

namespace JustBetter\AkeneoProducts\Jobs\ProductModel;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use JustBetter\AkeneoProducts\Contracts\ProductModel\RetrievesProductModel;

class RetrieveProductModelJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(
        public string $code
    ) {
        $this->onQueue(config('akeneo-products.queue'));
    }

    public function handle(RetrievesProductModel $retrievesProductModel): void
    {
        $retrievesProductModel->retrieve($this->code);
    }

    public function uniqueId(): string
    {
        return $this->code;
    }

    public function tags(): array
    {
        return [
            $this->code,
        ];
    }
}
