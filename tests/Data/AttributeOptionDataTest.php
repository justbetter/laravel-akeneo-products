<?php

declare(strict_types=1);

namespace JustBetter\AkeneoProducts\Tests\Data;

use JustBetter\AkeneoProducts\Data\AttributeOptionData;
use JustBetter\AkeneoProducts\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class AttributeOptionDataTest extends TestCase
{
    #[Test]
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

        $this->assertSame('code', $attributeOptionData->code());
        $this->assertSame('attribute', $attributeOptionData->attribute());
        $this->assertSame(0, $attributeOptionData->sortOrder());
        $this->assertSame(['nl_NL' => 'label'], $attributeOptionData->labels());
    }
}
