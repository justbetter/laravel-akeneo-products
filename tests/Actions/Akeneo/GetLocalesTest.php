<?php

namespace JustBetter\AkeneoProducts\Tests\Actions\Akeneo;

use Illuminate\Support\Facades\Http;
use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoProducts\Actions\Akeneo\GetLocales;
use JustBetter\AkeneoProducts\Tests\TestCase;

class GetLocalesTest extends TestCase
{
    /** @test */
    public function it_can_get_locales(): void
    {
        Akeneo::fake();

        Http::fake([
            'akeneo/api/rest/v1/locales?*' => Http::response([
                '_links' => [
                    'first' => [
                        'href' => 'akeneo/api/rest/v1/locales',
                    ],
                ],
                '_embedded' => [
                    'items' => [
                        [
                            'code' => 'nl_NL',
                            'enabled' => true,
                        ],
                        [
                            'code' => 'en_US',
                            'enabled' => true,
                        ],
                    ],
                ],
            ]),
        ]);

        /** @var GetLocales $action */
        $action = app(GetLocales::class);

        $scopes = $action->get();

        $this->assertEquals(2, $scopes->count());
    }
}
