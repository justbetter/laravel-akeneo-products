<?php

namespace JustBetter\AkeneoProducts\Tests\Actions\Akeneo;

use Illuminate\Support\Collection;
use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoProducts\Actions\Akeneo\FormatAttributeValues;
use JustBetter\AkeneoProducts\Contracts\Akeneo\GetsAttributes;
use JustBetter\AkeneoProducts\Contracts\Akeneo\GetsLocales;
use JustBetter\AkeneoProducts\Contracts\Akeneo\GetsScopes;
use JustBetter\AkeneoProducts\Data\AttributeData;
use JustBetter\AkeneoProducts\Data\LocaleData;
use JustBetter\AkeneoProducts\Data\ScopeData;
use JustBetter\AkeneoProducts\Tests\TestCase;
use Mockery\MockInterface;

class FormatAttributeValuesTest extends TestCase
{
    /** @test */
    public function it_can_format_attribute_values_unscoped_unlocalized(): void
    {
        Akeneo::fake();

        $this->mock(GetsAttributes::class, function (MockInterface $mock): void {
            $mock
                ->shouldReceive('get')
                ->with('code')
                ->once()
                ->andReturn(AttributeData::of([
                    'code' => 'text',
                    'type' => 'pim_catalog_text',
                    'unique' => false,
                    'localizable' => false,
                    'scopable' => false,
                ]));
        });

        $this->mock(GetsScopes::class, function (MockInterface $mock): void {
            $mock
                ->shouldReceive('get')
                ->once()
                ->andReturn(new Collection([
                    ScopeData::of([
                        'code' => 'ecommerce',
                        'locales' => [
                            'nl_NL',
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

        /** @var FormatAttributeValues $action */
        $action = app(FormatAttributeValues::class);

        $values = $action->format('code', 'My Value');

        $this->assertEquals([
            [
                'locale' => null,
                'scope' => null,
                'data' => 'My Value',
            ],
        ], $values);
    }

    /** @test */
    public function it_can_format_attribute_values_unscoped_localized(): void
    {
        Akeneo::fake();

        $this->mock(GetsAttributes::class, function (MockInterface $mock): void {
            $mock
                ->shouldReceive('get')
                ->with('code')
                ->once()
                ->andReturn(AttributeData::of([
                    'code' => 'text',
                    'type' => 'pim_catalog_text',
                    'unique' => false,
                    'localizable' => true,
                    'scopable' => false,
                ]));
        });

        $this->mock(GetsScopes::class, function (MockInterface $mock): void {
            $mock
                ->shouldReceive('get')
                ->once()
                ->andReturn(new Collection([
                    ScopeData::of([
                        'code' => 'ecommerce',
                        'locales' => [
                            'nl_NL',
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

        /** @var FormatAttributeValues $action */
        $action = app(FormatAttributeValues::class);

        $values = $action->format('code', 'My Value');

        $this->assertEquals([
            [
                'locale' => 'nl_NL',
                'scope' => null,
                'data' => 'My Value',
            ],
        ], $values);
    }

    /** @test */
    public function it_can_format_attribute_values_scoped_unlocalized(): void
    {
        Akeneo::fake();

        $this->mock(GetsAttributes::class, function (MockInterface $mock): void {
            $mock
                ->shouldReceive('get')
                ->with('code')
                ->once()
                ->andReturn(AttributeData::of([
                    'code' => 'text',
                    'type' => 'pim_catalog_text',
                    'unique' => false,
                    'localizable' => false,
                    'scopable' => true,
                ]));
        });

        $this->mock(GetsScopes::class, function (MockInterface $mock): void {
            $mock
                ->shouldReceive('get')
                ->once()
                ->andReturn(new Collection([
                    ScopeData::of([
                        'code' => 'ecommerce',
                        'locales' => [
                            'nl_NL',
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

        /** @var FormatAttributeValues $action */
        $action = app(FormatAttributeValues::class);

        $values = $action->format('code', 'My Value');

        $this->assertEquals([
            [
                'locale' => null,
                'scope' => 'ecommerce',
                'data' => 'My Value',
            ],
        ], $values);
    }

    /** @test */
    public function it_can_format_attribute_values_scoped_localized(): void
    {
        Akeneo::fake();

        $this->mock(GetsAttributes::class, function (MockInterface $mock): void {
            $mock
                ->shouldReceive('get')
                ->with('code')
                ->once()
                ->andReturn(AttributeData::of([
                    'code' => 'text',
                    'type' => 'pim_catalog_text',
                    'unique' => false,
                    'localizable' => true,
                    'scopable' => true,
                ]));
        });

        $this->mock(GetsScopes::class, function (MockInterface $mock): void {
            $mock
                ->shouldReceive('get')
                ->once()
                ->andReturn(new Collection([
                    ScopeData::of([
                        'code' => 'ecommerce',
                        'locales' => [
                            'nl_NL',
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

        /** @var FormatAttributeValues $action */
        $action = app(FormatAttributeValues::class);

        $values = $action->format('code', 'My Value');

        $this->assertEquals([
            [
                'locale' => 'nl_NL',
                'scope' => 'ecommerce',
                'data' => 'My Value',
            ],
        ], $values);
    }
}
