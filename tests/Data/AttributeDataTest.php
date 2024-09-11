<?php

namespace JustBetter\AkeneoProducts\Tests\Data;

use JustBetter\AkeneoProducts\Data\AttributeData;
use JustBetter\AkeneoProducts\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AttributeDataTest extends TestCase
{
    #[Test]
    public function it_can_interact_with_attribute_data(): void
    {
        $attributeData = AttributeData::of([
            'code' => 'code',
            'type' => 'pim_catalog_text',
            'unique' => false,
            'localizable' => false,
            'scopable' => false,
        ]);

        $this->assertEquals('code', $attributeData->code());
        $this->assertEquals('pim_catalog_text', $attributeData->type());
        $this->assertFalse($attributeData->unique());
        $this->assertFalse($attributeData->localizable());
        $this->assertFalse($attributeData->scopable());
    }
}
