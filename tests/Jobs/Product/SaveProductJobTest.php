<?php

namespace JustBetter\AkeneoProducts\Tests\Jobs\Product;

use Exception;
use JustBetter\AkeneoProducts\Contracts\Product\SavesProduct;
use JustBetter\AkeneoProducts\Data\ProductData;
use JustBetter\AkeneoProducts\Jobs\Product\SaveProductJob;
use JustBetter\AkeneoProducts\Jobs\Product\UpdateProductJob;
use JustBetter\AkeneoProducts\Models\Product;
use JustBetter\AkeneoProducts\Tests\TestCase;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;

class SaveProductJobTest extends TestCase
{
    #[Test]
    public function it_can_save_products(): void
    {
        $productData = ProductData::of([
            'identifier' => 'identifier',
            'values' => [
                'name' => [
                    [
                        'locale' => 'nl_NL',
                        'scope' => 'ecommerce',
                        'data' => 'Ziggy',
                    ],
                ],
            ],
        ]);

        $this->mock(SavesProduct::class, function (MockInterface $mock): void {
            $mock
                ->shouldReceive('save')
                ->once()
                ->andReturn();
        });

        SaveProductJob::dispatch($productData);
    }

    #[Test]
    public function it_has_correct_tags_and_unique_id(): void
    {
        $productData = ProductData::of([
            'identifier' => 'identifier',
            'values' => [
                'name' => [
                    [
                        'locale' => 'nl_NL',
                        'scope' => 'ecommerce',
                        'data' => 'Ziggy',
                    ],
                ],
            ],
        ]);

        $job = new SaveProductJob($productData);

        $this->assertEquals(['identifier'], $job->tags());
        $this->assertEquals('identifier', $job->uniqueId());
    }

    #[Test]
    public function it_can_fail(): void
    {
        /** @var Product $product */
        $product = Product::query()->create([
            'identifier' => 'identifier',
            'data' => [],
        ]);

        $productData = ProductData::of([
            'identifier' => 'identifier',
            'values' => [
                'name' => [
                    [
                        'locale' => 'nl_NL',
                        'scope' => 'ecommerce',
                        'data' => 'Ziggy',
                    ],
                ],
            ],
        ]);

        $job = new SaveProductJob($productData);
        $job->failed(new Exception);

        $product->refresh();

        $this->assertNotNull($product->failed_at);
    }

    #[Test]
    public function it_can_fail_without_product_model(): void
    {
        $productData = ProductData::of([
            'identifier' => 'identifier',
            'values' => [
                'name' => [
                    [
                        'locale' => 'nl_NL',
                        'scope' => 'ecommerce',
                        'data' => 'Ziggy',
                    ],
                ],
            ],
        ]);

        $job = new SaveProductJob($productData);
        $job->failed(new Exception);

        $this->assertTrue(true, 'No exception thrown');
    }
}
