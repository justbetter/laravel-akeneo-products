<?php

namespace JustBetter\AkeneoProducts\Tests\Jobs\Product;

use JustBetter\AkeneoProducts\Contracts\Product\ProcessesProducts;
use JustBetter\AkeneoProducts\Jobs\Product\ProcessProductsJob;
use JustBetter\AkeneoProducts\Tests\TestCase;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;

class ProcessProductsJobTest extends TestCase
{
    #[Test]
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
