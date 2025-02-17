<?php

namespace JustBetter\AkeneoProducts\Tests\Jobs\ProductModel;

use Exception;
use JustBetter\AkeneoProducts\Contracts\ProductModel\SavesProductModel;
use JustBetter\AkeneoProducts\Data\ProductModelData;
use JustBetter\AkeneoProducts\Jobs\ProductModel\SaveProductModelJob;
use JustBetter\AkeneoProducts\Models\ProductModel;
use JustBetter\AkeneoProducts\Tests\TestCase;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;

class SaveProductModelJobTest extends TestCase
{
    #[Test]
    public function it_can_save_product_models(): void
    {
        $productModelData = ProductModelData::of([
            'code' => 'code',
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

        $this->mock(SavesProductModel::class, function (MockInterface $mock): void {
            $mock
                ->shouldReceive('save')
                ->once()
                ->andReturn();
        });

        SaveProductModelJob::dispatch($productModelData);
    }

    #[Test]
    public function it_has_correct_tags_and_unique_id(): void
    {
        $productModelData = ProductModelData::of([
            'code' => 'code',
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

        $job = new SaveProductModelJob($productModelData);

        $this->assertEquals(['code'], $job->tags());
        $this->assertEquals('code', $job->uniqueId());
    }

    #[Test]
    public function it_can_fail(): void
    {
        /** @var ProductModel $product */
        $product = ProductModel::query()->create([
            'code' => 'code',
            'data' => [],
        ]);

        $productModelData = ProductModelData::of([
            'code' => 'code',
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

        $job = new SaveProductModelJob($productModelData);
        $job->failed(new Exception);

        $product->refresh();

        $this->assertNotNull($product->failed_at);
    }

    #[Test]
    public function it_can_fail_without_product_model(): void
    {
        $this->expectNotToPerformAssertions();

        $productModelData = ProductModelData::of([
            'code' => 'code',
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

        $job = new SaveProductModelJob($productModelData);
        $job->failed(new Exception);
    }
}
