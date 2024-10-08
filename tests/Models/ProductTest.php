<?php

namespace JustBetter\AkeneoProducts\Tests\Models;

use JustBetter\AkeneoProducts\Models\Product;
use JustBetter\AkeneoProducts\Tests\Fakes\Retrievers\Product\ProductRetriever;
use JustBetter\AkeneoProducts\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ProductTest extends TestCase
{
    #[Test]
    public function it_can_stop_the_synchronization(): void
    {
        config()->set('akeneo-products.retrievers.product', ProductRetriever::class);

        /** @var Product $product */
        $product = Product::query()->create([
            'identifier' => 'identifier',
            'synchronize' => true,
            'data' => [],
        ]);

        $product->failed();

        $this->assertNotNull($product->failed_at);
        $this->assertEquals(1, $product->fail_count);
        $this->assertTrue($product->synchronize);

        $product->failed();

        $this->assertNotNull($product->failed_at);
        $this->assertEquals(2, $product->fail_count);
        $this->assertFalse($product->synchronize);
    }
}
