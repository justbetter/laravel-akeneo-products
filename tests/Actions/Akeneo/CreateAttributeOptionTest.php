<?php

namespace JustBetter\AkeneoProducts\Tests\Actions\Akeneo;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoProducts\Actions\Akeneo\CreateAttributeOption;
use JustBetter\AkeneoProducts\Contracts\Akeneo\GetsAttributeOptions;
use JustBetter\AkeneoProducts\Data\AttributeOptionData;
use JustBetter\AkeneoProducts\Tests\TestCase;
use Mockery\MockInterface;

class CreateAttributeOptionTest extends TestCase
{
    /** @test */
    public function it_can_create_attribute_options(): void
    {
        Akeneo::fake();
        Http::fake();

        $this->mock(GetsAttributeOptions::class, function (MockInterface $mock): void {
            $mock
                ->shouldReceive('get')
                ->with('code')
                ->once()
                ->andReturn(new Collection([
                    AttributeOptionData::of([
                        'code' => 'optionCode',
                        'attribute' => 'code',
                        'sort_order' => 0,
                        'labels' => [
                            'nl_NL' => 'label',
                        ],
                    ]),
                ]));
        });

        /** @var CreateAttributeOption $action */
        $action = app(CreateAttributeOption::class);
        $action->create('code', 'optionCode', [
            'labels' => [
                'nl_NL' => 'label',
            ],
        ]);

        $payload = [
            'code' => 'code',
            'optionCode' => 'optionCode',
            'labels' => [
                'nl_NL' => 'label',
            ],
        ];

        Http::assertSent(function (Request $request) use ($payload): bool {
            if ($request->url() === 'akeneo/api/oauth/v1/token') {
                return true;
            }

            if ($request->url() === 'akeneo/api/rest/v1/attributes/code/options') {
                return $request->data() === $payload;
            }

            return false;
        });
    }
}
