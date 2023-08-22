<?php

namespace JustBetter\AkeneoProducts\Tests\Actions\Product;

use JustBetter\AkeneoProducts\Actions\Product\SaveProduct;
use JustBetter\AkeneoProducts\Data\ProductData;
use JustBetter\AkeneoProducts\Models\Product;
use JustBetter\AkeneoProducts\Tests\TestCase;

class SaveProductTest extends TestCase
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
                'color' => [
                    [
                        'locale' => null,
                        'scope' => null,
                        'data' => 'purple',
                    ],
                ],
            ],
        ]);

        /** @var SaveProduct $action */
        $action = app(SaveProduct::class);
        $action->save($productData);

        /** @var Product $product */
        $product = Product::query()
            ->where('identifier', '=', 'identifier')
            ->firstOrFail();

        $this->assertTrue($product->update);

        $product->update = false;
        $product->save();

        $productData = ProductData::of([
            'identifier' => 'identifier',
            'values' => [
                'color' => [
                    [
                        'locale' => null,
                        'scope' => null,
                        'data' => 'purple',
                    ],
                ],
                'name' => [
                    [
                        'locale' => 'nl_NL',
                        'scope' => 'ecommerce',
                        'data' => 'Ziggy',
                    ],
                ],
            ],
        ]);

        $action->save($productData);

        $product->refresh();

        $this->assertTrue($product->update);

        $product->update = false;
        $product->save();

        $productData = ProductData::of([
            'identifier' => 'identifier',
            'values' => [
                'color' => [
                    [
                        'locale' => null,
                        'scope' => null,
                        'data' => 'purple',
                    ],
                ],
                'name' => [
                    [
                        'locale' => 'nl_NL',
                        'scope' => 'ecommerce',
                        'data' => 'Ziggy',
                    ],
                ],
            ],
        ]);

        $action->save($productData);

        $product->refresh();

        $this->assertFalse($product->update);
    }
}
