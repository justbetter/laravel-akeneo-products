<?php

namespace JustBetter\AkeneoProducts\Tests\Models;

use JustBetter\AkeneoProducts\Models\ProductModel;
use JustBetter\AkeneoProducts\Tests\Fakes\Retrievers\ProductModel\ProductModelRetriever;
use JustBetter\AkeneoProducts\Tests\TestCase;

class ProductModelTest extends TestCase
{
    /** @test */
    public function it_can_stop_the_synchronization(): void
    {
        config()->set('akeneo-products.retrievers.product_model', ProductModelRetriever::class);

        /** @var ProductModel $productModel */
        $productModel = ProductModel::query()->create([
            'code' => 'code',
            'synchronize' => true,
            'data' => [],
        ]);

        $productModel->failed();

        $this->assertNotNull($productModel->failed_at);
        $this->assertEquals(1, $productModel->fail_count);
        $this->assertTrue($productModel->synchronize);

        $productModel->failed();

        $this->assertNotNull($productModel->failed_at);
        $this->assertEquals(2, $productModel->fail_count);
        $this->assertFalse($productModel->synchronize);
    }
}
