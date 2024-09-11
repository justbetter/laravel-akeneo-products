<?php

namespace JustBetter\AkeneoProducts\Tests\Actions\ProductModel;

use Illuminate\Support\Facades\Bus;
use JustBetter\AkeneoProducts\Actions\ProductModel\RetrieveProductModel;
use JustBetter\AkeneoProducts\Jobs\ProductModel\SaveProductModelJob;
use JustBetter\AkeneoProducts\Tests\Fakes\Retrievers\ProductModel\ProductModelRetriever;
use JustBetter\AkeneoProducts\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class RetrieveProductModelTest extends TestCase
{
    #[Test]
    public function it_can_retrieve_product_models(): void
    {
        Bus::fake();

        config()->set('akeneo-products.retrievers.product_model', ProductModelRetriever::class);

        /** @var RetrieveProductModel $action */
        $action = app(RetrieveProductModel::class);
        $action->retrieve('code');

        Bus::assertDispatched(SaveProductModelJob::class);
    }
}
