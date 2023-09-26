<?php

namespace JustBetter\AkeneoProducts\Tests\Actions\ProductModel;

use Illuminate\Support\Facades\Bus;
use JustBetter\AkeneoProducts\Actions\ProductModel\ProcessProductModels;
use JustBetter\AkeneoProducts\Jobs\ProductModel\RetrieveProductModelJob;
use JustBetter\AkeneoProducts\Jobs\ProductModel\UpdateProductModelJob;
use JustBetter\AkeneoProducts\Models\ProductModel;
use JustBetter\AkeneoProducts\Tests\Fakes\Retrievers\ProductModel\ProductModelRetriever;
use JustBetter\AkeneoProducts\Tests\TestCase;

class ProcessProductModelsTest extends TestCase
{
    /** @test */
    public function it_can_process_product_models(): void
    {
        Bus::fake();

        config()->set('akeneo-products.retrievers.product_model', ProductModelRetriever::class);

        ProductModel::query()->insert([
            [
                'code' => 'code-1',
                'synchronize' => false,
                'retrieve' => true,
                'update' => false,
                'data' => '{}',
            ],
            [
                'code' => 'code-2',
                'synchronize' => true,
                'retrieve' => true,
                'update' => false,
                'data' => '{}',
            ],
            [
                'code' => 'code-3',
                'synchronize' => true,
                'retrieve' => false,
                'update' => false,
                'data' => '{}',
            ],
            [
                'code' => 'code-4',
                'synchronize' => true,
                'retrieve' => false,
                'update' => true,
                'data' => '{}',
            ],
            [
                'code' => 'code-5',
                'synchronize' => true,
                'retrieve' => false,
                'update' => true,
                'data' => '{}',
            ],
            [
                'code' => 'code-6',
                'synchronize' => true,
                'retrieve' => false,
                'update' => true,
                'data' => '{}',
            ],
        ]);

        /** @var ProcessProductModels $action */
        $action = app(ProcessProductModels::class);
        $action->process();

        Bus::assertDispatched(RetrieveProductModelJob::class, 1);
        Bus::assertDispatched(UpdateProductModelJob::class, 2);
    }
}
