<?php

namespace JustBetter\AkeneoProducts\Jobs\Product;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use JustBetter\AkeneoProducts\Contracts\Product\SavesProduct;
use JustBetter\AkeneoProducts\Data\ProductData;
use JustBetter\AkeneoProducts\Models\Product;
use Spatie\Activitylog\ActivityLogger;
use Throwable;

class SaveProductJob implements ShouldBeUnique, ShouldQueue
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

    public function failed(Throwable $throwable): void
    {
        /** @var ?Product $model */
        $model = Product::query()->firstWhere('identifier', '=', $this->productData->identifier());

        $model?->failed();

        activity()
            ->when($model, function (ActivityLogger $logger, Product $product): ActivityLogger {
                return $logger->on($product);
            })
            ->useLog('error')
            ->withProperties([
                'data' => $this->productData->toArray(),
            ])
            ->log('Failed to save the product data: '.$throwable->getMessage());
    }
}
