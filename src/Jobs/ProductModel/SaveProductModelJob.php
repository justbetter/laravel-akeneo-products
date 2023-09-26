<?php

namespace JustBetter\AkeneoProducts\Jobs\ProductModel;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use JustBetter\AkeneoProducts\Contracts\ProductModel\SavesProductModel;
use JustBetter\AkeneoProducts\Data\ProductModelData;

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
}
