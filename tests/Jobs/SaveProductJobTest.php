<?php

namespace JustBetter\AkeneoProducts\Tests\Jobs;

use JustBetter\AkeneoProducts\Contracts\SavesProduct;
use JustBetter\AkeneoProducts\Data\ProductData;
use JustBetter\AkeneoProducts\Jobs\SaveProductJob;
use JustBetter\AkeneoProducts\Tests\TestCase;
use Mockery\MockInterface;

class SaveProductJobTest extends TestCase
{
    /** @test */
    public function it_can_save_products(): void
    {
        $productData = ProductData::of([
            'identifier' => 'identifier',
            'values' => [
                'name' => [
                    [
                        'locale' => 'nl_NL',
                        'scope' => 'ecommerce',
                        'data' => 'Ziggy',
                    ],
                ],
            ],
        ]);

        $this->mock(SavesProduct::class, function (MockInterface $mock): void {
            $mock
                ->shouldReceive('save')
                ->once()
                ->andReturn();
        });

        SaveProductJob::dispatch($productData);
    }

    /** @test */
    public function it_has_correct_tags_and_unique_id(): void
    {
        $productData = ProductData::of([
            'identifier' => 'identifier',
            'values' => [
                'name' => [
                    [
                        'locale' => 'nl_NL',
                        'scope' => 'ecommerce',
                        'data' => 'Ziggy',
                    ],
                ],
            ],
        ]);

        $job = new SaveProductJob($productData);

        $this->assertEquals(['identifier'], $job->tags());
        $this->assertEquals('identifier', $job->uniqueId());
    }
}
