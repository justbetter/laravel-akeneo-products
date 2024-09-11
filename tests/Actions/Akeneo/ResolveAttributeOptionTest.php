<?php

namespace JustBetter\AkeneoProducts\Tests\Actions\Akeneo;

use Illuminate\Support\Collection;
use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoProducts\Actions\Akeneo\ResolveAttributeOption;
use JustBetter\AkeneoProducts\Contracts\Akeneo\CreatesAttributeOptions;
use JustBetter\AkeneoProducts\Contracts\Akeneo\GetsAttributeOptions;
use JustBetter\AkeneoProducts\Contracts\Akeneo\GetsLocales;
use JustBetter\AkeneoProducts\Data\AttributeOptionData;
use JustBetter\AkeneoProducts\Data\LocaleData;
use JustBetter\AkeneoProducts\Tests\TestCase;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;

class ResolveAttributeOptionTest extends TestCase
{
    #[Test]
    public function it_can_resolve_attribute_options_using_code(): void
    {
        Akeneo::fake();

        $this->mock(GetsAttributeOptions::class, function (MockInterface $mock): void {
            $mock
                ->shouldReceive('get')
                ->with('code')
                ->once()
                ->andReturn(new Collection([
                    AttributeOptionData::of([
                        'code' => 'optionCode',
                        'attribute' => 'code',
                        'sort_order' => 0,
                        'labels' => [
                            'nl_NL' => 'label',
                        ],
                    ]),
                ]));
        });

        $this->mock(GetsLocales::class, function (MockInterface $mock): void {
            $mock->shouldNotReceive('get');
        });

        $this->mock(CreatesAttributeOptions::class, function (MockInterface $mock): void {
            $mock->shouldNotReceive('create');
        });

        /** @var ResolveAttributeOption $action */
        $action = app(ResolveAttributeOption::class);

        $data = $action->resolve('code', 'optionCode', 'label');

        $this->assertEquals('optionCode', $data->code());
    }

    #[Test]
    public function it_can_resolve_attribute_options_using_labels(): void
    {
        Akeneo::fake();

        $this->mock(GetsAttributeOptions::class, function (MockInterface $mock): void {
            $mock
                ->shouldReceive('get')
                ->with('code')
                ->once()
                ->andReturn(new Collection([
                    AttributeOptionData::of([
                        'code' => 'optionCode',
                        'attribute' => 'code',
                        'sort_order' => 0,
                        'labels' => [
                            'nl_NL' => 'label',
                        ],
                    ]),
                ]));
        });

        $this->mock(GetsLocales::class, function (MockInterface $mock): void {
            $mock->shouldNotReceive('get');
        });

        $this->mock(CreatesAttributeOptions::class, function (MockInterface $mock): void {
            $mock->shouldNotReceive('create');
        });

        /** @var ResolveAttributeOption $action */
        $action = app(ResolveAttributeOption::class);

        $data = $action->resolve('code', 'optionCode2', 'label');

        $this->assertEquals('optionCode', $data->code());
    }

    #[Test]
    public function it_can_resolve_attribute_options_by_creating_a_new_option(): void
    {
        Akeneo::fake();

        $this->mock(GetsAttributeOptions::class, function (MockInterface $mock): void {
            $mock
                ->shouldReceive('get')
                ->with('code')
                ->once()
                ->andReturn(new Collection([
                    AttributeOptionData::of([
                        'code' => 'optionCode',
                        'attribute' => 'code',
                        'sort_order' => 0,
                        'labels' => [
                            'nl_NL' => 'label',
                        ],
                    ]),
                ]));
        });

        $this->mock(GetsLocales::class, function (MockInterface $mock): void {
            $mock
                ->shouldReceive('get')
                ->once()
                ->andReturn(new Collection([
                    LocaleData::of([
                        'code' => 'nl_NL',
                        'enabled' => true,
                    ]),
                ]));
        });

        $this->mock(CreatesAttributeOptions::class, function (MockInterface $mock): void {
            $mock
                ->shouldReceive('create')
                ->once()
                ->andReturnUsing(function (string $code, string $optionCode, array $labels): AttributeOptionData {
                    return AttributeOptionData::of([
                        'code' => $optionCode,
                        'attribute' => $code,
                        'sort_order' => 0,
                        'labels' => $labels,
                    ]);
                });
        });

        /** @var ResolveAttributeOption $action */
        $action = app(ResolveAttributeOption::class);

        $data = $action->resolve('code', 'optionCode2', 'label2');

        $this->assertEquals('optionCode2', $data->code());
    }
}
