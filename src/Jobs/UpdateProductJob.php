<?php

namespace JustBetter\AkeneoProducts\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use JustBetter\AkeneoProducts\Contracts\UpdatesProduct;
use JustBetter\AkeneoProducts\Models\Product;

class UpdateProductJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Product $product
    ) {
        $this->onQueue(config('akeneo-products.queue'));
    }

    public function handle(UpdatesProduct $updatesProduct): void
    {
        $updatesProduct->update($this->product);
    }

    public function uniqueId(): string
    {
        return $this->product->identifier;
    }

    public function tags(): array
    {
        return [
            $this->product->identifier,
        ];
    }

    public function failed(): void
    {
        $this->product->failed();
    }
}
