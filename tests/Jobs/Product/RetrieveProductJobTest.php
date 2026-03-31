<?php

declare(strict_types=1);

namespace JustBetter\AkeneoProducts\Tests\Jobs\Product;

use Exception;
use Illuminate\Support\Carbon;
use JustBetter\AkeneoProducts\Contracts\Product\RetrievesProduct;
use JustBetter\AkeneoProducts\Jobs\Product\RetrieveProductJob;
use JustBetter\AkeneoProducts\Models\Product;
use JustBetter\AkeneoProducts\Tests\TestCase;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;

final class RetrieveProductJobTest extends TestCase
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

        $this->assertSame(['identifier'], $job->tags());
        $this->assertSame('identifier', $job->uniqueId());
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

        $this->assertInstanceOf(Carbon::class, $product->failed_at);
    }

    #[Test]
    public function it_can_fail_without_product_model(): void
    {
        $this->expectNotToPerformAssertions();

        $job = new RetrieveProductJob('identifier');
        $job->failed(new Exception);
    }
}
