<?php

namespace JustBetter\AkeneoProducts\Tests\Jobs\Product;

use Exception;
use JustBetter\AkeneoProducts\Contracts\Product\RetrievesProduct;
use JustBetter\AkeneoProducts\Jobs\Product\RetrieveProductJob;
use JustBetter\AkeneoProducts\Models\Product;
use JustBetter\AkeneoProducts\Tests\TestCase;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;

class RetrieveProductJobTest extends TestCase
{
    #[Test]
    public function it_can_retrieve_products(): void
    {
        $this->mock(RetrievesProduct::class, function (MockInterface $mock): void {
            $mock
                ->shouldReceive('retrieve')
                ->with('identifier')
                ->once()
                ->andReturn();
        });

        RetrieveProductJob::dispatch('identifier');
    }

    #[Test]
    public function it_has_correct_tags_and_unique_id(): void
    {
        $job = new RetrieveProductJob('identifier');

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

        $job = new RetrieveProductJob('identifier');
        $job->failed(new Exception);

        $product->refresh();

        $this->assertNotNull($product->failed_at);
    }

    #[Test]
    public function it_can_fail_without_product_model(): void
    {
        $job = new RetrieveProductJob('identifier');
        $job->failed(new Exception);

        $this->assertTrue(true, 'No exception thrown');
    }
}
