<?php

namespace JustBetter\AkeneoProducts\Jobs\ProductModel;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use JustBetter\AkeneoProducts\Contracts\ProductModel\SavesProductModel;
use JustBetter\AkeneoProducts\Data\ProductModelData;
use JustBetter\AkeneoProducts\Models\ProductModel;
use JustBetter\MagentoPrices\Models\Price;
use Spatie\Activitylog\ActivityLogger;
use Throwable;

class SaveProductModelJob implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(
        public ProductModelData $productModelData
    ) {
        $this->onQueue(config('akeneo-products.queue'));
    }

    public function handle(SavesProductModel $savesProductModel): void
    {
        $savesProductModel->save($this->productModelData);
    }

    public function uniqueId(): string
    {
        return $this->productModelData->code();
    }

    public function tags(): array
    {
        return [
            $this->productModelData->code(),
        ];
    }

    public function failed(Throwable $throwable): void
    {
        /** @var ?ProductModel $model */
        $model = ProductModel::query()->firstWhere('code', '=', $this->productModelData->code());

        $model?->failed();

        activity()
            ->when($model, function (ActivityLogger $logger, ProductModel $productModel): ActivityLogger {
                return $logger->on($productModel);
            })
            ->useLog('error')
            ->log('Failed to save the productmodel: '.$throwable->getMessage());
    }
}
