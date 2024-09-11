<?php

namespace JustBetter\AkeneoProducts\Tests\Jobs\ProductModel;

use JustBetter\AkeneoProducts\Contracts\ProductModel\ProcessesProductModels;
use JustBetter\AkeneoProducts\Jobs\ProductModel\ProcessProductModelsJob;
use JustBetter\AkeneoProducts\Tests\TestCase;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;

class ProcessProductModelsJobTest extends TestCase
{
    #[Test]
    public function it_can_process_product_models(): void
    {
        $this->mock(ProcessesProductModels::class, function (MockInterface $mock): void {
            $mock
                ->shouldReceive('process')
                ->once()
                ->andReturn();
        });

        ProcessProductModelsJob::dispatch();
    }
}
