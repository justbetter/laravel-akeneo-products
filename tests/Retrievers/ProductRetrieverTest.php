<?php

namespace JustBetter\AkeneoProducts\Tests\Retrievers;

use JustBetter\AkeneoProducts\Exceptions\NotImplementedException;
use JustBetter\AkeneoProducts\Retrievers\ProductRetriever;
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
