<?php

namespace JustBetter\AkeneoProducts\Tests\Actions\Product;

use Illuminate\Support\Facades\Bus;
use JustBetter\AkeneoProducts\Actions\Product\ProcessProducts;
use JustBetter\AkeneoProducts\Jobs\Product\RetrieveProductJob;
use JustBetter\AkeneoProducts\Jobs\Product\UpdateProductJob;
use JustBetter\AkeneoProducts\Models\Product;
use JustBetter\AkeneoProducts\Tests\Fakes\Retrievers\Product\ProductRetriever;
use JustBetter\AkeneoProducts\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ProcessProductsTest extends TestCase
{
    #[Test]
    public function it_can_process_products(): void
    {
        Bus::fake();

        config()->set('akeneo-products.retrievers.product', ProductRetriever::class);

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
