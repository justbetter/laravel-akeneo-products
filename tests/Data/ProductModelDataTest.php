<?php

declare(strict_types=1);

namespace JustBetter\AkeneoProducts\Tests\Data;

use JustBetter\AkeneoProducts\Data\ProductModelData;
use JustBetter\AkeneoProducts\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class ProductModelDataTest extends TestCase
{
    #[Test]
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

        $this->assertSame('code', $productModelData->code());
        $this->assertSame('family', $productModelData->family());
        $this->assertSame(['category'], $productModelData->categories());
        $this->assertSame([
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
