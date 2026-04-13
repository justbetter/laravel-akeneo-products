<?php

declare(strict_types=1);

namespace JustBetter\AkeneoProducts\Tests\Actions\Product;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoProducts\Actions\Product\UpdateProduct;
use JustBetter\AkeneoProducts\Models\Product;
use JustBetter\AkeneoProducts\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class UpdateProductTest extends TestCase
{
    #[Test]
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
            'fail_count' => 1,
            'failed_at' => now(),
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

        $this->assertInstanceOf(Carbon::class, $product->modified_at);
        $this->assertFalse($product->update);
        $this->assertEquals(0, $product->fail_count);
        $this->assertNotInstanceOf(Carbon::class, $product->failed_at);
    }
}
