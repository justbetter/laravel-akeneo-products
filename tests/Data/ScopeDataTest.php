<?php

namespace JustBetter\AkeneoProducts\Tests\Data;

use JustBetter\AkeneoProducts\Data\ScopeData;
use JustBetter\AkeneoProducts\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ScopeDataTest extends TestCase
{
    #[Test]
    public function it_can_interact_with_scope_data(): void
    {
        $scopeData = ScopeData::of([
            'code' => 'ecommerce',
            'locales' => [
                'nl_NL',
            ],
        ]);

        $this->assertEquals('ecommerce', $scopeData->code());
        $this->assertEquals(['nl_NL'], $scopeData->locales());
    }
}
