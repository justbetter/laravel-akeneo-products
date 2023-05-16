<?php

namespace JustBetter\AkeneoProducts\Tests\Akeneo\Types;

use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoProducts\Akeneo\Types\PriceCollectionType;
use JustBetter\AkeneoProducts\Data\AttributeData;
use JustBetter\AkeneoProducts\Exceptions\InvalidValueException;
use JustBetter\AkeneoProducts\Tests\TestCase;

class PriceCollectionTypeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Akeneo::fake();
    }

    /** @test */
    public function it_can_be_matched(): void
    {
        /** @var PriceCollectionType $type */
        $type = app(PriceCollectionType::class);

        $this->assertTrue(
            $type->matches('pim_catalog_price_collection')
        );
    }

    /** @test */
    public function it_throws_exception_for_invalid_type(): void
    {
        /** @var PriceCollectionType $type */
        $type = app(PriceCollectionType::class);

        $this->expectException(InvalidValueException::class);

        $attributeData = AttributeData::of([
            'code' => 'price',
            'type' => 'pim_catalog_price_collection',
            'unique' => false,
            'localizable' => false,
            'scopable' => false,
        ]);

        $type->format($attributeData, new \stdClass());
    }

    /**
     * @test
     *
     * @dataProvider values
     */
    public function it_can_be_formatted(mixed $input, mixed $output): void
    {
        /** @var PriceCollectionType $type */
        $type = app(PriceCollectionType::class);

        $attributeData = AttributeData::of([
            'code' => 'price',
            'type' => 'pim_catalog_price_collection',
            'unique' => false,
            'localizable' => false,
            'scopable' => false,
        ]);

        $value = $type->format($attributeData, $input);

        $this->assertEquals($output, $value);
    }

    public static function values(): array
    {
        return [
            'default_currency_string' => [
                'input' => '10.00',
                'output' => [
                    [
                        'amount' => '10.00',
                        'currency' => 'EUR',
                    ],
                ],
            ],
            'default_currency_float' => [
                'input' => 10.00,
                'output' => [
                    [
                        'amount' => '10.00',
                        'currency' => 'EUR',
                    ],
                ],
            ],
            'custom_currency' => [
                'input' => ['10.00', 'GBP'],
                'output' => [
                    [
                        'amount' => '10.00',
                        'currency' => 'GBP',
                    ],
                ],
            ],
        ];
    }
}
