<?php

namespace JustBetter\AkeneoProducts\Tests\Fakes\Retrievers;

use JustBetter\AkeneoProducts\Data\ProductData;
use JustBetter\AkeneoProducts\Retrievers\BaseRetriever;

class TestRetriever extends BaseRetriever
{
    public function retrieve(string $identifier): ?ProductData
    {
        return ProductData::of([
            'identifier' => 'identifier',
            'values' => [
                'name' => [
                    [
                        'locale' => 'nl_NL',
                        'scope' => 'ecommerce',
                        'data' => 'Ziggy',
                    ],
                ],
            ],
        ]);
    }
}
