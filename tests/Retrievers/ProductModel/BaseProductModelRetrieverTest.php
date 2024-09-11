<?php

namespace JustBetter\AkeneoProducts\Tests\Retrievers\ProductModel;

use JustBetter\AkeneoProducts\Retrievers\ProductModel\BaseProductModelRetriever;
use JustBetter\AkeneoProducts\Retrievers\ProductModel\ProductModelRetriever;
use JustBetter\AkeneoProducts\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class BaseProductModelRetrieverTest extends TestCase
{
    #[Test]
    public function it_can_get_the_current_retriever(): void
    {
        $retriever = BaseProductModelRetriever::current();

        $this->assertTrue($retriever instanceof ProductModelRetriever);
    }
}
