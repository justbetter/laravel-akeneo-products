<?php

namespace JustBetter\AkeneoProducts\Jobs\Product;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use JustBetter\AkeneoProducts\Contracts\Product\RetrievesProduct;
use JustBetter\AkeneoProducts\Models\Product;
use Spatie\Activitylog\ActivityLogger;
use Throwable;

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

    public function failed(Throwable $throwable): void
    {
        /** @var ?Product $model */
        $model = Product::query()->firstWhere('identifier', '=', $this->identifier);

        $model?->failed();

        activity()
            ->when($model, function (ActivityLogger $logger, Product $product): ActivityLogger {
                return $logger->on($product);
            })
            ->useLog('error')
            ->log('Failed to retrieve the product: '.$throwable->getMessage());
    }
}
