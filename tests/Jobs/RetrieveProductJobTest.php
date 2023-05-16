<?php

namespace JustBetter\AkeneoProducts\Tests\Jobs;

use JustBetter\AkeneoProducts\Contracts\RetrievesProduct;
use JustBetter\AkeneoProducts\Jobs\RetrieveProductJob;
use JustBetter\AkeneoProducts\Tests\TestCase;
use Mockery\MockInterface;

class RetrieveProductJobTest extends TestCase
{
    /** @test */
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

    /** @test */
    public function it_has_correct_tags_and_unique_id(): void
    {
        $job = new RetrieveProductJob('identifier');

        $this->assertEquals(['identifier'], $job->tags());
        $this->assertEquals('identifier', $job->uniqueId());
    }
}
