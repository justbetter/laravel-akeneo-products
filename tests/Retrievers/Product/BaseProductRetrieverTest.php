<?php

namespace JustBetter\AkeneoProducts\Tests\Retrievers\Product;

use JustBetter\AkeneoProducts\Retrievers\Product\BaseProductRetriever;
use JustBetter\AkeneoProducts\Retrievers\Product\ProductRetriever;
use JustBetter\AkeneoProducts\Tests\TestCase;

class BaseProductRetrieverTest extends TestCase
{
    /** @test */
    public function it_can_get_the_current_retriever(): void
    {
        $retriever = BaseProductRetriever::current();

        $this->assertTrue($retriever instanceof ProductRetriever);
    }
}
