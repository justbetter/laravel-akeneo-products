<?php

namespace JustBetter\AkeneoProducts\Tests\Commands;

use Illuminate\Support\Facades\Bus;
use Illuminate\Testing\PendingCommand;
use JustBetter\AkeneoProducts\Commands\RetrieveProductCommand;
use JustBetter\AkeneoProducts\Jobs\RetrieveProductJob;
use JustBetter\AkeneoProducts\Tests\TestCase;

class RetrieveProductCommandTest extends TestCase
{
    /** @test */
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
