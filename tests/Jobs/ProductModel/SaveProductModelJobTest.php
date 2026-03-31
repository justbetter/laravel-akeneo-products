<?php

declare(strict_types=1);

namespace JustBetter\AkeneoProducts\Tests\Jobs\ProductModel;

use Exception;
use Illuminate\Support\Carbon;
use JustBetter\AkeneoProducts\Contracts\ProductModel\SavesProductModel;
use JustBetter\AkeneoProducts\Data\ProductModelData;
use JustBetter\AkeneoProducts\Jobs\ProductModel\SaveProductModelJob;
use JustBetter\AkeneoProducts\Models\ProductModel;
use JustBetter\AkeneoProducts\Tests\TestCase;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;

final class SaveProductModelJobTest extends TestCase
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

        $this->assertSame(['code'], $job->tags());
        $this->assertSame('code', $job->uniqueId());
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

        $this->assertInstanceOf(Carbon::class, $product->failed_at);
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
