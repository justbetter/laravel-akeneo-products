<?php

namespace JustBetter\AkeneoProducts\Tests\Retrievers\Product;

use JustBetter\AkeneoProducts\Exceptions\NotImplementedException;
use JustBetter\AkeneoProducts\Retrievers\Product\ProductRetriever;
use JustBetter\AkeneoProducts\Tests\TestCase;

class ProductRetrieverTest extends TestCase
{
    /** @test */
    public function it_can_throw_exceptions(): void
    {
        $this->expectException(NotImplementedException::class);

        /** @var ProductRetriever $retriever */
        $retriever = app(ProductRetriever::class);
        $retriever->retrieve('identifier');
    }
}
