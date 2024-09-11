<?php

namespace JustBetter\AkeneoProducts\Tests\Jobs\ProductModel;

use JustBetter\AkeneoProducts\Contracts\ProductModel\RetrievesProductModel;
use JustBetter\AkeneoProducts\Jobs\ProductModel\RetrieveProductModelJob;
use JustBetter\AkeneoProducts\Tests\TestCase;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;

class RetrieveProductModelJobTest extends TestCase
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

        $this->assertEquals(['code'], $job->tags());
        $this->assertEquals('code', $job->uniqueId());
    }
}
