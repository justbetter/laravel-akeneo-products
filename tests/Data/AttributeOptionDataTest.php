<?php

namespace JustBetter\AkeneoProducts\Tests\Data;

use JustBetter\AkeneoProducts\Data\AttributeOptionData;
use JustBetter\AkeneoProducts\Tests\TestCase;

class AttributeOptionDataTest extends TestCase
{
    /** @test */
    public function it_can_interact_with_attribute_option_data(): void
    {
        $attributeOptionData = AttributeOptionData::of([
            'code' => 'code',
            'attribute' => 'attribute',
            'sort_order' => 0,
            'labels' => [
                'nl_NL' => 'label',
            ],
        ]);

        $this->assertEquals('code', $attributeOptionData->code());
        $this->assertEquals('attribute', $attributeOptionData->attribute());
        $this->assertEquals(0, $attributeOptionData->sortOrder());
        $this->assertEquals(['nl_NL' => 'label'], $attributeOptionData->labels());
    }
}
