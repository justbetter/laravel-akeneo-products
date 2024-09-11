<?php

namespace JustBetter\AkeneoProducts\Tests\Commands\Product;

use Illuminate\Support\Facades\Bus;
use Illuminate\Testing\PendingCommand;
use JustBetter\AkeneoProducts\Commands\Product\ProcessProductsCommand;
use JustBetter\AkeneoProducts\Jobs\Product\ProcessProductsJob;
use JustBetter\AkeneoProducts\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ProcessProductsCommandTest extends TestCase
{
    #[Test]
    public function it_can_dispatch_jobs(): void
    {
        Bus::fake();

        /** @var PendingCommand $artisan */
        $artisan = $this->artisan(ProcessProductsCommand::class);

        $artisan
            ->assertSuccessful()
            ->run();

        Bus::assertDispatched(ProcessProductsJob::class);
    }
}
