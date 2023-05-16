<?php

namespace JustBetter\AkeneoProducts\Tests\Models;

use JustBetter\AkeneoProducts\Enums\MappingType;
use JustBetter\AkeneoProducts\Models\Mapping;
use JustBetter\AkeneoProducts\Tests\TestCase;

class MappingTest extends TestCase
{
    /** @test */
    public function it_can_get_a_mapping(): void
    {
        /** @var Mapping $mapping */
        $mapping = Mapping::query()->create([
            'type' => MappingType::Attribute,
            'source' => 'source',
            'destination' => 'destination',
        ]);

        $sourceMapping = Mapping::get(MappingType::Attribute, 'source');

        $this->assertEquals($mapping->id, $sourceMapping?->id);
    }
}
