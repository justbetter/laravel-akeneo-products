<?php

namespace JustBetter\AkeneoProducts\Tests\Akeneo\Types;

use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoProducts\Akeneo\Types\MetricType;
use JustBetter\AkeneoProducts\Data\AttributeData;
use JustBetter\AkeneoProducts\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class MetricTypeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Akeneo::fake();
    }

    #[Test]
    public function it_can_be_matched(): void
    {
        /** @var MetricType $type */
        $type = app(MetricType::class);

        $this->assertTrue(
            $type->matches('pim_catalog_metric')
        );
    }

    #[Test]
    #[DataProvider('values')]
    public function it_can_be_formatted(mixed $input, array $output): void
    {
        /** @var MetricType $type */
        $type = app(MetricType::class);

        $attributeData = AttributeData::of([
            'code' => 'metric',
            'type' => 'pim_catalog_metric',
            'unique' => false,
            'localizable' => false,
            'scopable' => false,
            'default_metric_unit' => 'cm',
        ]);

        $value = $type->format($attributeData, $input);

        $this->assertEquals($output, $value);
    }

    public static function values(): array
    {
        return [
            [
                'input' => 100,
                'output' => [
                    'amount' => 100,
                    'unit' => 'cm',
                ],
            ],
            [
                'input' => [
                    1,
                    'm',
                ],
                'output' => [
                    'amount' => 1,
                    'unit' => 'm',
                ],
            ],
        ];
    }
}
