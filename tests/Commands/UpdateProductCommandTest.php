<?php

namespace JustBetter\AkeneoProducts\Tests\Commands;

use Illuminate\Support\Facades\Bus;
use Illuminate\Testing\PendingCommand;
use JustBetter\AkeneoProducts\Commands\UpdateProductCommand;
use JustBetter\AkeneoProducts\Jobs\UpdateProductJob;
use JustBetter\AkeneoProducts\Models\Product;
use JustBetter\AkeneoProducts\Tests\TestCase;

class UpdateProductCommandTest extends TestCase
{
    /** @test */
    public function it_can_dispatch_jobs(): void
    {
        Bus::fake();

        /** @var Product $product */
        $product = Product::query()->create([
            'identifier' => 'identifier',
            'data' => [],
        ]);

        /** @var PendingCommand $artisan */
        $artisan = $this->artisan(UpdateProductCommand::class, [
            'identifier' => $product->identifier,
        ]);

        $artisan
            ->assertSuccessful()
            ->run();

        Bus::assertDispatched(UpdateProductJob::class);
    }
}
