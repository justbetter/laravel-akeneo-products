<?php

namespace JustBetter\AkeneoProducts\Jobs\Product;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use JustBetter\AkeneoProducts\Contracts\Product\SavesProduct;
use JustBetter\AkeneoProducts\Data\ProductData;

class SaveProductJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(
        public ProductData $productData
    ) {
        $this->onQueue(config('akeneo-products.queue'));
    }

    public function handle(SavesProduct $savesProduct): void
    {
        $savesProduct->save($this->productData);
    }

    public function uniqueId(): string
    {
        return $this->productData->identifier();
    }

    public function tags(): array
    {
        return [
            $this->productData->identifier(),
        ];
    }
}
