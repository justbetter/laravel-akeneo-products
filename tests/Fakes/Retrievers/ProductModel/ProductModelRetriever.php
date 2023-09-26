<?php

namespace JustBetter\AkeneoProducts\Tests\Fakes\Retrievers\ProductModel;

use JustBetter\AkeneoProducts\Data\ProductModelData;
use JustBetter\AkeneoProducts\Retrievers\ProductModel\BaseProductModelRetriever;

class ProductModelRetriever extends BaseProductModelRetriever
{
    protected int $tries = 2;

    protected int $retrieveBatchSize = 2;

    protected int $updateBatchSize = 2;

    public function retrieve(string $code): ?ProductModelData
    {
        return ProductModelData::of([
            'code' => 'code',
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
