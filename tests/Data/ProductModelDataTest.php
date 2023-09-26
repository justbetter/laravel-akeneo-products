<?php

namespace JustBetter\AkeneoProducts\Tests\Data;

use JustBetter\AkeneoProducts\Data\ProductModelData;
use JustBetter\AkeneoProducts\Tests\TestCase;

class ProductModelDataTest extends TestCase
{
    /** @test */
    public function it_can_interact_with_product_model_data(): void
    {
        $productModelData = ProductModelData::of([
            'code' => 'code',
            'family' => 'family',
            'categories' => [
                'category',
            ],
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

        $this->assertEquals('code', $productModelData->code());
        $this->assertEquals('family', $productModelData->family());
        $this->assertEquals(['category'], $productModelData->categories());
        $this->assertEquals([
            'name' => [
                [
                    'locale' => 'nl_NL',
                    'scope' => 'ecommerce',
                    'data' => 'Ziggy',
                ],
            ],
        ], $productModelData->values());
    }
}
