<?php

declare(strict_types=1);

namespace JustBetter\AkeneoProducts\Tests\Data;

use JustBetter\AkeneoProducts\Data\ProductData;
use JustBetter\AkeneoProducts\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class ProductDataTest extends TestCase
{
    #[Test]
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

        $this->assertSame('identifier', $productData->identifier());
        $this->assertSame('family', $productData->family());
        $this->assertSame(['category'], $productData->categories());
        $this->assertSame([
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
