<?php

namespace JustBetter\AkeneoProducts\Tests\Jobs\Product;

use Exception;
use JustBetter\AkeneoProducts\Contracts\Product\UpdatesProduct;
use JustBetter\AkeneoProducts\Jobs\Product\UpdateProductJob;
use JustBetter\AkeneoProducts\Models\Product;
use JustBetter\AkeneoProducts\Tests\TestCase;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;

class UpdateProductJobTest extends TestCase
{
    #[Test]
    public function it_can_update_products(): void
    {
        /** @var Product $product */
        $product = Product::query()->create([
            'identifier' => 'identifier',
            'data' => [],
        ]);

        $this->mock(UpdatesProduct::class, function (MockInterface $mock): void {
            $mock
                ->shouldReceive('update')
                ->once()
                ->andReturn();
        });

        UpdateProductJob::dispatch($product);
    }

    #[Test]
    public function it_can_fail(): void
    {
        /** @var Product $product */
        $product = Product::query()->create([
            'identifier' => 'identifier',
            'data' => [],
        ]);

        $job = new UpdateProductJob($product);
        $job->failed(new Exception);

        $this->assertNotNull($product->failed_at);
    }

    #[Test]
    public function it_has_correct_tags_and_unique_id(): void
    {
        /** @var Product $product */
        $product = Product::query()->create([
            'identifier' => 'identifier',
            'data' => [],
        ]);

        $job = new UpdateProductJob($product);

        $this->assertEquals(['identifier'], $job->tags());
        $this->assertEquals('identifier', $job->uniqueId());
    }
}
