<?php

namespace JustBetter\AkeneoProducts\Jobs\ProductModel;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use JustBetter\AkeneoProducts\Contracts\ProductModel\RetrievesProductModel;
use JustBetter\AkeneoProducts\Models\ProductModel;
use Spatie\Activitylog\ActivityLogger;
use Throwable;

class RetrieveProductModelJob implements ShouldBeUnique, ShouldQueue
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

    public function failed(Throwable $throwable): void
    {
        /** @var ?ProductModel $model */
        $model = ProductModel::query()->firstWhere('code', '=', $this->code);

        $model?->failed();

        activity()
            ->when($model !== null, fn (ActivityLogger $logger): ActivityLogger => $logger->on($model))
            ->useLog('error')
            ->log('Failed to retrieve the productmodel: '.$throwable->getMessage());
    }
}
