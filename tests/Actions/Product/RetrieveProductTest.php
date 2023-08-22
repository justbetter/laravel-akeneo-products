<?php

namespace JustBetter\AkeneoProducts\Tests\Actions\Product;

use Illuminate\Support\Facades\Bus;
use JustBetter\AkeneoProducts\Actions\Product\RetrieveProduct;
use JustBetter\AkeneoProducts\Jobs\Product\SaveProductJob;
use JustBetter\AkeneoProducts\Tests\Fakes\Retrievers\Product\ProductRetriever;
use JustBetter\AkeneoProducts\Tests\TestCase;

class RetrieveProductTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_products(): void
    {
        Bus::fake();

        config()->set('akeneo-products.retrievers.product', ProductRetriever::class);

        /** @var RetrieveProduct $action */
        $action = app(RetrieveProduct::class);
        $action->retrieve('identifier');

        Bus::assertDispatched(SaveProductJob::class);
    }
}
