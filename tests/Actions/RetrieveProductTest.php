<?php

namespace JustBetter\AkeneoProducts\Tests\Actions;

use Illuminate\Support\Facades\Bus;
use JustBetter\AkeneoProducts\Actions\RetrieveProduct;
use JustBetter\AkeneoProducts\Jobs\SaveProductJob;
use JustBetter\AkeneoProducts\Tests\Fakes\Retrievers\TestRetriever;
use JustBetter\AkeneoProducts\Tests\TestCase;

class RetrieveProductTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_products(): void
    {
        Bus::fake();

        config()->set('akeneo-products.retriever', TestRetriever::class);

        /** @var RetrieveProduct $action */
        $action = app(RetrieveProduct::class);
        $action->retrieve('identifier');

        Bus::assertDispatched(SaveProductJob::class);
    }
}
