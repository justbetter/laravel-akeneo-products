<?php

namespace JustBetter\AkeneoProducts\Tests\Commands\ProductModel;

use Illuminate\Support\Facades\Bus;
use Illuminate\Testing\PendingCommand;
use JustBetter\AkeneoProducts\Commands\ProductModel\UpdateProductModelCommand;
use JustBetter\AkeneoProducts\Jobs\ProductModel\UpdateProductModelJob;
use JustBetter\AkeneoProducts\Models\ProductModel;
use JustBetter\AkeneoProducts\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UpdateProductModelCommandTest extends TestCase
{
    #[Test]
    public function it_can_dispatch_jobs(): void
    {
        Bus::fake();

        /** @var ProductModel $productModel */
        $productModel = ProductModel::query()->create([
            'code' => 'code',
            'data' => [],
        ]);

        /** @var PendingCommand $artisan */
        $artisan = $this->artisan(UpdateProductModelCommand::class, [
            'code' => $productModel->code,
        ]);

        $artisan
            ->assertSuccessful()
            ->run();

        Bus::assertDispatched(UpdateProductModelJob::class);
    }
}
