<?php

namespace JustBetter\AkeneoProducts\Tests\Commands\Product;

use Illuminate\Support\Facades\Bus;
use Illuminate\Testing\PendingCommand;
use JustBetter\AkeneoProducts\Commands\Product\RetrieveProductCommand;
use JustBetter\AkeneoProducts\Jobs\Product\RetrieveProductJob;
use JustBetter\AkeneoProducts\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class RetrieveProductCommandTest extends TestCase
{
    #[Test]
    public function it_can_dispatch_jobs(): void
    {
        Bus::fake();

        /** @var PendingCommand $artisan */
        $artisan = $this->artisan(RetrieveProductCommand::class, [
            'identifier' => 'identifier',
        ]);

        $artisan
            ->assertSuccessful()
            ->run();

        Bus::assertDispatched(RetrieveProductJob::class);
    }
}
