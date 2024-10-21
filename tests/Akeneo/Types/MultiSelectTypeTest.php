<?php

namespace JustBetter\AkeneoProducts\Tests\Akeneo\Types;

use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoProducts\Akeneo\Types\MultiSelectType;
use JustBetter\AkeneoProducts\Contracts\Akeneo\ResolvesAttributeOptions;
use JustBetter\AkeneoProducts\Data\AttributeData;
use JustBetter\AkeneoProducts\Data\AttributeOptionData;
use JustBetter\AkeneoProducts\Tests\TestCase;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class MultiSelectTypeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Akeneo::fake();
    }

    #[Test]
    public function it_can_be_matched(): void
    {
        /** @var MultiSelectType $type */
        $type = app(MultiSelectType::class);

        $this->assertTrue(
            $type->matches('pim_catalog_multiselect')
        );
    }

    #[Test]
    #[DataProvider('values')]
    public function it_can_be_formatted(mixed $input, mixed $output): void
    {
        $this->mock(ResolvesAttributeOptions::class, function (MockInterface $mock): void {
            $mock
                ->shouldReceive('resolve')
                ->andReturnUsing(function (string $code, string $optionCode, string $label): AttributeOptionData {
                    return AttributeOptionData::of([
                        'code' => $optionCode,
                        'attribute' => $code,
                        'sort_order' => 0,
                        'labels' => [
                            'nl_NL' => $label,
                        ],
                    ]);
                });
        });

        /** @var MultiSelectType $type */
        $type = app(MultiSelectType::class);

        $attributeData = AttributeData::of([
            'code' => 'multiselect',
            'type' => 'pim_catalog_multiselect',
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
                'input' => 'code',
                'output' => ['code'],
            ],
            [
                'input' => 'some-code',
                'output' => ['some_code'],
            ],
            [
                'input' => 'Hello!@#$%ˆ&*()World 123',
                'output' => ['Hello_World_123'],
            ],
            [
                'input' => [
                    'code',
                    'label',
                ],
                'output' => ['code'],
            ],
            [
                'input' => '',
                'output' => null,
            ],
        ];
    }
}
