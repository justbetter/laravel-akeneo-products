<?php

namespace JustBetter\AkeneoProducts\Tests\Data;

use Illuminate\Validation\ValidationException;
use JustBetter\AkeneoProducts\Data\ProductData;
use JustBetter\AkeneoProducts\Tests\TestCase;

class DataTest extends TestCase
{
    /** @test */
    public function it_can_interact_with_data(): void
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
            ],
        ]);

        $this->assertTrue(isset($productData['identifier']));
        $this->assertEquals('identifier', $productData['identifier']);

        $productData['identifier'] = 'update';

        $this->assertEquals('update', $productData['identifier']);

        unset($productData['identifier']);

        $this->assertNull($productData['identifier']);
    }

    public function it_can_throw_exceptions(): void
    {
        $this->expectException(ValidationException::class);

        ProductData::of([
            'identifier' => 'identifier',
        ]);
    }
}
