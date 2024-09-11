<?php

namespace JustBetter\AkeneoProducts\Tests\Jobs\ProductModel;

use Exception;
use JustBetter\AkeneoProducts\Contracts\ProductModel\UpdatesProductModel;
use JustBetter\AkeneoProducts\Jobs\ProductModel\UpdateProductModelJob;
use JustBetter\AkeneoProducts\Models\ProductModel;
use JustBetter\AkeneoProducts\Tests\TestCase;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;

class UpdateProductModelJobTest extends TestCase
{
    #[Test]
    public function it_can_update_product_models(): void
    {
        /** @var ProductModel $productModel */
        $productModel = ProductModel::query()->create([
            'code' => 'code',
            'data' => [],
        ]);

        $this->mock(UpdatesProductModel::class, function (MockInterface $mock): void {
            $mock
                ->shouldReceive('update')
                ->once()
                ->andReturn();
        });

        UpdateProductModelJob::dispatch($productModel);
    }

    #[Test]
    public function it_can_fail(): void
    {
        /** @var ProductModel $productModel */
        $productModel = ProductModel::query()->create([
            'code' => 'code',
            'data' => [],
        ]);

        $job = new UpdateProductModelJob($productModel);
        $job->failed(new Exception);

        $this->assertNotNull($productModel->failed_at);
    }

    #[Test]
    public function it_has_correct_tags_and_unique_id(): void
    {
        /** @var ProductModel $productModel */
        $productModel = ProductModel::query()->create([
            'code' => 'code',
            'data' => [],
        ]);

        $job = new UpdateProductModelJob($productModel);

        $this->assertEquals(['code'], $job->tags());
        $this->assertEquals('code', $job->uniqueId());
    }
}
