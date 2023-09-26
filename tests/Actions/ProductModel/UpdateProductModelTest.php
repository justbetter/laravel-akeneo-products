<?php

namespace JustBetter\AkeneoProducts\Tests\Actions\ProductModel;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoProducts\Actions\ProductModel\UpdateProductModel;
use JustBetter\AkeneoProducts\Models\ProductModel;
use JustBetter\AkeneoProducts\Tests\TestCase;

class UpdateProductModelTest extends TestCase
{
    /** @test */
    public function it_can_update_product_models(): void
    {
        Akeneo::fake();
        Http::fake();

        $payload = [
            'code' => 'code',
            'values' => [
                'name' => [
                    [
                        'locale' => 'nl_NL',
                        'scope' => 'ecommerce',
                        'data' => 'Ziggy',
                    ],
                ],
            ],
        ];

        /** @var ProductModel $productModel */
        $productModel = ProductModel::query()->create([
            'code' => 'code',
            'data' => $payload,
        ]);

        /** @var UpdateProductModel $action */
        $action = app(UpdateProductModel::class);
        $action->update($productModel);

        Http::assertSent(function (Request $request) use ($payload): bool {
            if ($request->url() === 'akeneo/api/oauth/v1/token') {
                return true;
            }

            if ($request->url() === 'akeneo/api/rest/v1/product-models/code') {
                return $request->data() === $payload;
            }

            return false;
        });

        $this->assertNotNull($productModel->modified_at);
        $this->assertFalse($productModel->update);
    }
}
