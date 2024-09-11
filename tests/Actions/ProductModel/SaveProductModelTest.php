<?php

namespace JustBetter\AkeneoProducts\Tests\Actions\ProductModel;

use JustBetter\AkeneoProducts\Actions\ProductModel\SaveProductModel;
use JustBetter\AkeneoProducts\Data\ProductModelData;
use JustBetter\AkeneoProducts\Models\ProductModel;
use JustBetter\AkeneoProducts\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class SaveProductModelTest extends TestCase
{
    #[Test]
    public function it_can_save_product_models(): void
    {
        $productModelData = ProductModelData::of([
            'code' => 'code',
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

        /** @var SaveProductModel $action */
        $action = app(SaveProductModel::class);
        $action->save($productModelData);

        /** @var ProductModel $productModel */
        $productModel = ProductModel::query()
            ->where('code', '=', 'code')
            ->firstOrFail();

        $this->assertTrue($productModel->update);

        $productModel->update = false;
        $productModel->save();

        $productModelData = ProductModelData::of([
            'code' => 'code',
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

        $action->save($productModelData);

        $productModel->refresh();

        $this->assertTrue($productModel->update);

        $productModel->update = false;
        $productModel->save();

        $productModelData = ProductModelData::of([
            'code' => 'code',
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

        $action->save($productModelData);

        $productModel->refresh();

        $this->assertFalse($productModel->update);
    }
}
