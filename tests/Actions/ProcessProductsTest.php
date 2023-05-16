<?php

namespace JustBetter\AkeneoProducts\Tests\Actions;

use Illuminate\Support\Facades\Bus;
use JustBetter\AkeneoProducts\Actions\ProcessProducts;
use JustBetter\AkeneoProducts\Jobs\RetrieveProductJob;
use JustBetter\AkeneoProducts\Jobs\UpdateProductJob;
use JustBetter\AkeneoProducts\Models\Product;
use JustBetter\AkeneoProducts\Tests\TestCase;

class ProcessProductsTest extends TestCase
{
    /** @test */
    public function it_can_process_products(): void
    {
        Bus::fake();

        config()->set('akeneo-products.retrieve_batch_size', 2);
        config()->set('akeneo-products.update_batch_size', 2);

        Product::query()->insert([
            [
                'identifier' => 'identifier-1',
                'synchronize' => false,
                'retrieve' => true,
                'update' => false,
                'data' => '{}',
            ],
            [
                'identifier' => 'identifier-2',
                'synchronize' => true,
                'retrieve' => true,
                'update' => false,
                'data' => '{}',
            ],
            [
                'identifier' => 'identifier-3',
                'synchronize' => true,
                'retrieve' => false,
                'update' => false,
                'data' => '{}',
            ],
            [
                'identifier' => 'identifier-4',
                'synchronize' => true,
                'retrieve' => false,
                'update' => true,
                'data' => '{}',
            ],
            [
                'identifier' => 'identifier-5',
                'synchronize' => true,
                'retrieve' => false,
                'update' => true,
                'data' => '{}',
            ],
            [
                'identifier' => 'identifier-6',
                'synchronize' => true,
                'retrieve' => false,
                'update' => true,
                'data' => '{}',
            ],
        ]);

        /** @var ProcessProducts $action */
        $action = app(ProcessProducts::class);
        $action->process();

        Bus::assertDispatched(RetrieveProductJob::class, 1);
        Bus::assertDispatched(UpdateProductJob::class, 2);
    }
}
