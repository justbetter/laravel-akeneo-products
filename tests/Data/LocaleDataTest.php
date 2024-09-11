<?php

namespace JustBetter\AkeneoProducts\Tests\Data;

use JustBetter\AkeneoProducts\Data\LocaleData;
use JustBetter\AkeneoProducts\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class LocaleDataTest extends TestCase
{
    #[Test]
    public function it_can_interact_with_locale_data(): void
    {
        $localeData = LocaleData::of([
            'code' => 'nl_NL',
            'enabled' => true,
        ]);

        $this->assertEquals('nl_NL', $localeData->code());
        $this->assertTrue($localeData->enabled());
    }
}
