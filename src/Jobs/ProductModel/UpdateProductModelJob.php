<?php

namespace JustBetter\AkeneoProducts\Jobs\ProductModel;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use JustBetter\AkeneoProducts\Contracts\ProductModel\UpdatesProductModel;
use JustBetter\AkeneoProducts\Models\ProductModel;
use Akeneo\Pim\ApiClient\Exception\UnprocessableEntityHttpException;
use Throwable;

class UpdateProductModelJob implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public ProductModel $productModel
    ) {
        $this->onQueue(config('akeneo-products.queue'));
    }

    public function handle(UpdatesProductModel $updatesProductModel): void
    {
        $updatesProductModel->update($this->productModel);
    }

    public function uniqueId(): string
    {
        return $this->productModel->code;
    }

    public function tags(): array
    {
        return [
            $this->productModel->code,
        ];
    }

    public function failed(Throwable $throwable): void
    {
        $this->productModel->failed();

        $responseErrors = $throwable instanceof UnprocessableEntityHttpException
            ? $throwable->getResponseErrors() // @codeCoverageIgnore
            : [];

        activity()
            ->on($this->productModel)
            ->useLog('error')
            ->withProperties([
                'message' => $throwable->getMessage(),
                'code' => $throwable->getCode(),
                'response_errors' =>  $responseErrors
            ])
            ->log('Failed to update product model in Akeneo');
    }
}
