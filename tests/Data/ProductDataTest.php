<?php

namespace JustBetter\AkeneoProducts\Tests\Data;

use JustBetter\AkeneoProducts\Data\ProductData;
use JustBetter\AkeneoProducts\Tests\TestCase;

class ProductDataTest extends TestCase
{
    /** @test */
    public function it_can_interact_with_product_data(): void
    {
        $productData = ProductData::of([
            'identifier' => 'identifier',
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

        $this->assertEquals('identifier', $productData->identifier());
        $this->assertEquals('family', $productData->family());
        $this->assertEquals(['category'], $productData->categories());
        $this->assertEquals([
            'name' => [
                [
                    'locale' => 'nl_NL',
                    'scope' => 'ecommerce',
                    'data' => 'Ziggy',
                ],
            ],
        ], $productData->values());
    }
}
