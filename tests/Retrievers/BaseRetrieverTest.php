<?php

namespace JustBetter\AkeneoProducts\Tests\Retrievers;

use JustBetter\AkeneoProducts\Retrievers\BaseRetriever;
use JustBetter\AkeneoProducts\Retrievers\ProductRetriever;
use JustBetter\AkeneoProducts\Tests\TestCase;

class BaseRetrieverTest extends TestCase
{
    /** @test */
    public function it_can_get_the_current_retriever(): void
    {
        $retriever = BaseRetriever::current();

        $this->assertNotNull($retriever instanceof ProductRetriever);
    }
}
