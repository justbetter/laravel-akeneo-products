<?php

namespace JustBetter\AkeneoProducts\Tests\Akeneo\Types;

use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoProducts\Akeneo\Types\SimpleType;
use JustBetter\AkeneoProducts\Data\AttributeData;
use JustBetter\AkeneoProducts\Tests\TestCase;

class SimpleTypeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Akeneo::fake();
    }

    /** @test */
    public function it_can_be_matched(): void
    {
        /** @var SimpleType $type */
        $type = app(SimpleType::class);

        $this->assertTrue(
            $type->matches('pim_catalog_text')
        );
    }

    /**
     * @test
     *
     * @dataProvider values
     */
    public function it_can_be_formatted(mixed $input, mixed $output): void
    {
        /** @var SimpleType $type */
        $type = app(SimpleType::class);

        $attributeData = AttributeData::of([
            'code' => 'text',
            'type' => 'pim_catalog_text',
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
                'input' => 'Value',
                'output' => 'Value',
            ],
            [
                'input' => 1.925,
                'output' => '1.925',
            ],
        ];
    }
}
