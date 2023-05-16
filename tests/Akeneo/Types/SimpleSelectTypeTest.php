<?php

namespace JustBetter\AkeneoProducts\Tests\Akeneo\Types;

use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoProducts\Akeneo\Types\SimpleSelectType;
use JustBetter\AkeneoProducts\Contracts\Akeneo\ResolvesAttributeOptions;
use JustBetter\AkeneoProducts\Data\AttributeData;
use JustBetter\AkeneoProducts\Data\AttributeOptionData;
use JustBetter\AkeneoProducts\Tests\TestCase;
use Mockery\MockInterface;

class SimpleSelectTypeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Akeneo::fake();
    }

    /** @test */
    public function it_can_be_matched(): void
    {
        /** @var SimpleSelectType $type */
        $type = app(SimpleSelectType::class);

        $this->assertTrue(
            $type->matches('pim_catalog_simpleselect')
        );
    }

    /**
     * @test
     *
     * @dataProvider values
     */
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

        /** @var SimpleSelectType $type */
        $type = app(SimpleSelectType::class);

        $attributeData = AttributeData::of([
            'code' => 'simpleselect',
            'type' => 'pim_catalog_simpleselect',
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
                'output' => 'code',
            ],
            [
                'input' => 'some-code',
                'output' => 'some_code',
            ],
            [
                'input' => 'Hello!@#$%ˆ&*()World 123',
                'output' => 'Hello_World_123',
            ],
            [
                'input' => [
                    'code',
                    'label',
                ],
                'output' => 'code',
            ],
            [
                'input' => '',
                'output' => null,
            ],
        ];
    }
}
