<?php

namespace JustBetter\AkeneoProducts\Tests\Fakes\Retrievers\Product;

use JustBetter\AkeneoProducts\Data\ProductData;
use JustBetter\AkeneoProducts\Retrievers\Product\BaseProductRetriever;

class ProductRetriever extends BaseProductRetriever
{
    protected int $tries = 2;

    protected int $retrieveBatchSize = 2;

    protected int $updateBatchSize = 2;

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
