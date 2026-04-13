<?php

declare(strict_types=1);

namespace JustBetter\AkeneoProducts\Tests\Jobs\ProductModel;

use Exception;
use Illuminate\Support\Carbon;
use JustBetter\AkeneoProducts\Contracts\ProductModel\RetrievesProductModel;
use JustBetter\AkeneoProducts\Jobs\ProductModel\RetrieveProductModelJob;
use JustBetter\AkeneoProducts\Models\ProductModel;
use JustBetter\AkeneoProducts\Tests\TestCase;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;

final class RetrieveProductModelJobTest extends TestCase
{
    #[Test]
    public function it_can_retrieve_product_models(): void
    {
        $this->mock(RetrievesProductModel::class, function (MockInterface $mock): void {
            $mock
                ->shouldReceive('retrieve')
                ->with('code')
                ->once()
                ->andReturn();
        });

        RetrieveProductModelJob::dispatch('code');
    }

    #[Test]
    public function it_has_correct_tags_and_unique_id(): void
    {
        $job = new RetrieveProductModelJob('code');

        $this->assertSame(['code'], $job->tags());
        $this->assertSame('code', $job->uniqueId());
    }

    #[Test]
    public function it_can_fail(): void
    {
        /** @var ProductModel $productModel */
        $productModel = ProductModel::query()->create([
            'code' => 'code',
            'data' => [],
        ]);

        $job = new RetrieveProductModelJob('code');
        $job->failed(new Exception);

        $productModel->refresh();

        $this->assertInstanceOf(Carbon::class, $productModel->failed_at);
    }

    #[Test]
    public function it_can_fail_without_product_model(): void
    {
        $this->expectNotToPerformAssertions();

        $job = new RetrieveProductModelJob('code');
        $job->failed(new Exception);
    }
}
