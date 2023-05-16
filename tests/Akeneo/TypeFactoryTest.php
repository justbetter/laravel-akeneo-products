<?php

namespace JustBetter\AkeneoProducts\Tests\Akeneo;

use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoProducts\Akeneo\TypeFactory;
use JustBetter\AkeneoProducts\Akeneo\Types\SimpleType;
use JustBetter\AkeneoProducts\Exceptions\InvalidTypeException;
use JustBetter\AkeneoProducts\Tests\TestCase;

class TypeFactoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Akeneo::fake();
    }

    /** @test */
    public function it_can_match_types(): void
    {
        /** @var TypeFactory $factory */
        $factory = app(TypeFactory::class);

        $baseType = $factory->for('pim_catalog_text');

        $this->assertTrue($baseType instanceof SimpleType);
    }

    /** @test */
    public function it_can_throw_exceptions(): void
    {
        $this->expectException(InvalidTypeException::class);

        /** @var TypeFactory $factory */
        $factory = app(TypeFactory::class);
        $factory->for('unknown');
    }
}
