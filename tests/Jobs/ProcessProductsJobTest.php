<?php

namespace JustBetter\AkeneoProducts\Tests\Jobs;

use JustBetter\AkeneoProducts\Contracts\ProcessesProducts;
use JustBetter\AkeneoProducts\Jobs\ProcessProductsJob;
use JustBetter\AkeneoProducts\Tests\TestCase;
use Mockery\MockInterface;

class ProcessProductsJobTest extends TestCase
{
    /** @test */
    public function it_can_process_products(): void
    {
        $this->mock(ProcessesProducts::class, function (MockInterface $mock): void {
            $mock
                ->shouldReceive('process')
                ->once()
                ->andReturn();
        });

        ProcessProductsJob::dispatch();
    }
}
