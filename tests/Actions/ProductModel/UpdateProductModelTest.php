<?php

namespace JustBetter\AkeneoProducts\Tests\Actions\ProductModel;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoProducts\Actions\ProductModel\UpdateProductModel;
use JustBetter\AkeneoProducts\Models\ProductModel;
use JustBetter\AkeneoProducts\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UpdateProductModelTest extends TestCase
{
    #[Test]
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
            'fail_count' => 1,
            'failed_at' => now(),
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
        $this->assertEquals(0, $productModel->fail_count);
        $this->assertNull($productModel->failed_at);
    }
}
