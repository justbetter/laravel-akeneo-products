<?php

declare(strict_types=1);

namespace JustBetter\AkeneoProducts\Tests\Actions\Akeneo;

use Illuminate\Support\Facades\Http;
use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoProducts\Actions\Akeneo\GetAttributeOptions;
use JustBetter\AkeneoProducts\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class GetAttributeOptionsTest extends TestCase
{
    #[Test]
    public function it_can_attribute_options(): void
    {
        Akeneo::fake();

        Http::fake([
            'akeneo/api/rest/v1/attributes/code/options' => Http::response([
                '_links' => [
                    'first' => [
                        'href' => 'akeneo/api/rest/v1/attributes/code/options',
                    ],
                ],
                '_embedded' => [
                    'items' => [
                        [
                            'code' => 'option-1',
                            'attribute' => 'code',
                            'sort_order' => 1,
                            'labels' => [
                                'nl_NL' => 'label',
                            ],
                        ],
                        [
                            'code' => 'option-2',
                            'attribute' => 'code',
                            'sort_order' => 1,
                            'labels' => [
                                'nl_NL' => 'label',
                            ],
                        ],
                        [
                            'code' => 'option-3',
                            'attribute' => 'code',
                            'sort_order' => 1,
                            'labels' => [
                                'nl_NL' => 'label',
                            ],
                        ],
                    ],
                ],
            ]),
        ])->preventStrayRequests();

        /** @var GetAttributeOptions $action */
        $action = app(GetAttributeOptions::class);

        $attributeOptions = $action->get('code');

        $this->assertCount(3, $attributeOptions);
    }
}
