<?php

namespace JustBetter\AkeneoProducts\Tests\Actions\Akeneo;

use Illuminate\Support\Facades\Http;
use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoProducts\Actions\Akeneo\GetScopes;
use JustBetter\AkeneoProducts\Tests\TestCase;

class GetScopesTest extends TestCase
{
    /** @test */
    public function it_can_get_scopes(): void
    {
        Akeneo::fake();

        Http::fake([
            'akeneo/api/rest/v1/channels?*' => Http::response([
                '_links' => [
                    'first' => [
                        'href' => 'akeneo/api/rest/v1/channels',
                    ],
                ],
                '_embedded' => [
                    'items' => [
                        [
                            'code' => 'scope-1',
                            'locales' => [
                                'nl_NL',
                            ],
                        ],
                        [
                            'code' => 'scope-2',
                            'locales' => [
                                'nl_NL',
                            ],
                        ],
                        [
                            'code' => 'scope-3',
                            'locales' => [
                                'nl_NL',
                            ],
                        ],
                    ],
                ],
            ]),
        ]);

        /** @var GetScopes $action */
        $action = app(GetScopes::class);

        $scopes = $action->get();

        $this->assertEquals(3, $scopes->count());
    }
}
