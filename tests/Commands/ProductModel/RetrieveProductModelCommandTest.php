<?php

namespace JustBetter\AkeneoProducts\Tests\Commands\ProductModel;

use Illuminate\Support\Facades\Bus;
use Illuminate\Testing\PendingCommand;
use JustBetter\AkeneoProducts\Commands\ProductModel\RetrieveProductModelCommand;
use JustBetter\AkeneoProducts\Jobs\ProductModel\RetrieveProductModelJob;
use JustBetter\AkeneoProducts\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class RetrieveProductModelCommandTest extends TestCase
{
    #[Test]
    public function it_can_dispatch_jobs(): void
    {
        Bus::fake();

        /** @var PendingCommand $artisan */
        $artisan = $this->artisan(RetrieveProductModelCommand::class, [
            'code' => 'code',
        ]);

        $artisan
            ->assertSuccessful()
            ->run();

        Bus::assertDispatched(RetrieveProductModelJob::class);
    }
}
