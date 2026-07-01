<?php

declare(strict_types=1);

namespace JustBetter\AkeneoProducts\Tests\Actions\Akeneo;

use Illuminate\Support\Facades\Http;
use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoProducts\Actions\Akeneo\GetLocales;
use JustBetter\AkeneoProducts\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class GetLocalesTest extends TestCase
{
    #[Test]
    public function it_can_get_locales(): void
    {
        Akeneo::fake();

        Http::fake([
            'akeneo/api/rest/v1/locales?search=%7B%22enabled%22%3A%5B%7B%22operator%22%3A%22%3D%22%2C%22value%22%3Atrue%7D%5D%7D&limit=100&with_count=false' => Http::response([
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
        ])->preventStrayRequests();

        /** @var GetLocales $action */
        $action = app(GetLocales::class);

        $scopes = $action->get();

        $this->assertCount(2, $scopes);
    }
}
