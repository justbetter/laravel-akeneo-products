<?php

namespace JustBetter\AkeneoProducts\Tests\Actions\Akeneo;

use Illuminate\Support\Facades\Http;
use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoProducts\Actions\Akeneo\GetAttribute;
use JustBetter\AkeneoProducts\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class GetAttributeTest extends TestCase
{
    #[Test]
    public function it_can_get_attributes(): void
    {
        Akeneo::fake();

        Http::fake([
            'akeneo/api/rest/v1/attributes/code' => Http::response([
                'code' => 'code',
                'type' => 'type',
                'unique' => false,
                'localizable' => false,
                'scopable' => false,
            ]),
        ]);

        /** @var GetAttribute $action */
        $action = app(GetAttribute::class);

        $attributeData = $action->get('code');

        $this->assertEquals('code', $attributeData->code());
    }
}
