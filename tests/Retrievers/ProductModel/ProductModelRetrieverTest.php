<?php

namespace JustBetter\AkeneoProducts\Tests\Retrievers\ProductModel;

use JustBetter\AkeneoProducts\Exceptions\NotImplementedException;
use JustBetter\AkeneoProducts\Retrievers\ProductModel\ProductModelRetriever;
use JustBetter\AkeneoProducts\Tests\TestCase;

class ProductModelRetrieverTest extends TestCase
{
    /** @test */
    public function it_can_throw_exceptions(): void
    {
        $this->expectException(NotImplementedException::class);

        /** @var ProductModelRetriever $retriever */
        $retriever = app(ProductModelRetriever::class);
        $retriever->retrieve('code');
    }
}
