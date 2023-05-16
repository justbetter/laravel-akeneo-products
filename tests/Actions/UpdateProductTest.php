<?php

namespace JustBetter\AkeneoProducts\Tests\Actions;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoProducts\Actions\UpdateProduct;
use JustBetter\AkeneoProducts\Models\Product;
use JustBetter\AkeneoProducts\Tests\TestCase;

class UpdateProductTest extends TestCase
{
    /** @test */
    public function it_can_update_products(): void
    {
        Akeneo::fake();
        Http::fake();

        $payload = [
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
        ];

        /** @var Product $product */
        $product = Product::query()->create([
            'identifier' => 'identifier',
            'data' => $payload,
        ]);

        /** @var UpdateProduct $action */
        $action = app(UpdateProduct::class);
        $action->update($product);

        Http::assertSent(function (Request $request) use ($payload): bool {
            if ($request->url() === 'akeneo/api/oauth/v1/token') {
                return true;
            }

            if ($request->url() === 'akeneo/api/rest/v1/products/identifier') {
                return $request->data() === $payload;
            }

            return false;
        });

        $this->assertNotNull($product->modified_at);
        $this->assertFalse($product->update);
    }
}
