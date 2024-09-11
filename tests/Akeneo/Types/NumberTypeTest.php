<?php

namespace JustBetter\AkeneoProducts\Tests\Akeneo\Types;

use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoProducts\Akeneo\Types\NumberType;
use JustBetter\AkeneoProducts\Data\AttributeData;
use JustBetter\AkeneoProducts\Exceptions\InvalidValueException;
use JustBetter\AkeneoProducts\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class NumberTypeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Akeneo::fake();
    }

    #[Test]
    public function it_can_be_matched(): void
    {
        /** @var NumberType $type */
        $type = app(NumberType::class);

        $this->assertTrue(
            $type->matches('pim_catalog_number')
        );
    }

    #[Test]
    #[DataProvider('decimalValues')]
    public function it_can_be_formatted_with_decimals(mixed $input, mixed $output): void
    {
        /** @var NumberType $type */
        $type = app(NumberType::class);

        $attributeData = AttributeData::of([
            'code' => 'number',
            'type' => 'pim_catalog_number',
            'unique' => false,
            'localizable' => false,
            'scopable' => false,
            'decimals_allowed' => true,
        ]);

        $value = $type->format($attributeData, $input);

        $this->assertEquals($output, $value);
    }

    public static function decimalValues(): array
    {
        return [
            [
                'input' => 1.000,
                'output' => 1.000,
            ],
            [
                'input' => 1.925,
                'output' => 1.925,
            ],
            [
                'input' => '5',
                'output' => 5,
            ],
            [
                'input' => '10.0',
                'output' => 10.0,
            ],
        ];
    }

    #[Test]
    #[DataProvider('integerValues')]
    public function it_can_be_formatted_with_integers(mixed $input, mixed $output): void
    {
        /** @var NumberType $type */
        $type = app(NumberType::class);

        $attributeData = AttributeData::of([
            'code' => 'number',
            'type' => 'pim_catalog_number',
            'unique' => false,
            'localizable' => false,
            'scopable' => false,
            'decimals_allowed' => false,
        ]);

        $value = $type->format($attributeData, $input);

        $this->assertEquals($output, $value);
    }

    public static function integerValues(): array
    {
        return [
            [
                'input' => 1.000,
                'output' => 1,
            ],
            [
                'input' => 1.925,
                'output' => 1,
            ],
            [
                'input' => '5',
                'output' => 5,
            ],
            [
                'input' => '10.0',
                'output' => 10,
            ],
        ];
    }

    #[Test]
    public function it_can_throw_exceptions(): void
    {
        $this->expectException(InvalidValueException::class);

        /** @var NumberType $type */
        $type = app(NumberType::class);

        $attributeData = AttributeData::of([
            'code' => 'number',
            'type' => 'pim_catalog_number',
            'unique' => false,
            'localizable' => false,
            'scopable' => false,
            'decimals_allowed' => true,
        ]);

        $type->format($attributeData, 'invalid');
    }
}
