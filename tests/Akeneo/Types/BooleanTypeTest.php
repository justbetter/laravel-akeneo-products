<?php

namespace JustBetter\AkeneoProducts\Tests\Akeneo\Types;

use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoProducts\Akeneo\Types\BooleanType;
use JustBetter\AkeneoProducts\Data\AttributeData;
use JustBetter\AkeneoProducts\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class BooleanTypeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Akeneo::fake();
    }

    #[Test]
    public function it_can_be_matched(): void
    {
        /** @var BooleanType $type */
        $type = app(BooleanType::class);

        $this->assertTrue(
            $type->matches('pim_catalog_boolean')
        );
    }

    #[Test]
    #[DataProvider('values')]
    public function it_can_be_formatted(mixed $input, bool $output): void
    {
        /** @var BooleanType $type */
        $type = app(BooleanType::class);

        $attributeData = AttributeData::of([
            'code' => 'boolean',
            'type' => 'pim_catalog_boolean',
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
            [
                'input' => 0,
                'output' => false,
            ],
            [
                'input' => 1,
                'output' => true,
            ],
            [
                'input' => '',
                'output' => false,
            ],
            [
                'input' => null,
                'output' => false,
            ],
            [
                'input' => false,
                'output' => false,
            ],
            [
                'input' => true,
                'output' => true,
            ],
        ];
    }
}
