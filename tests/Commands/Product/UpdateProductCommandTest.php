<?php

namespace JustBetter\AkeneoProducts\Tests\Commands\Product;

use Illuminate\Support\Facades\Bus;
use Illuminate\Testing\PendingCommand;
use JustBetter\AkeneoProducts\Commands\Product\UpdateProductCommand;
use JustBetter\AkeneoProducts\Jobs\Product\UpdateProductJob;
use JustBetter\AkeneoProducts\Models\Product;
use JustBetter\AkeneoProducts\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UpdateProductCommandTest extends TestCase
{
    #[Test]
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
