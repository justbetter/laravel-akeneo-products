<?php

namespace JustBetter\AkeneoProducts\Tests\Commands\ProductModel;

use Illuminate\Support\Facades\Bus;
use Illuminate\Testing\PendingCommand;
use JustBetter\AkeneoProducts\Commands\ProductModel\ProcessProductModelsCommand;
use JustBetter\AkeneoProducts\Jobs\ProductModel\ProcessProductModelsJob;
use JustBetter\AkeneoProducts\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ProcessProductModelsCommandTest extends TestCase
{
    #[Test]
    public function it_can_dispatch_jobs(): void
    {
        Bus::fake();

        /** @var PendingCommand $artisan */
        $artisan = $this->artisan(ProcessProductModelsCommand::class);

        $artisan
            ->assertSuccessful()
            ->run();

        Bus::assertDispatched(ProcessProductModelsJob::class);
    }
}
