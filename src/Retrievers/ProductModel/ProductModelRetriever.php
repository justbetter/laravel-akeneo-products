<?php

namespace JustBetter\AkeneoProducts\Retrievers\ProductModel;

use JustBetter\AkeneoProducts\Data\ProductModelData;
use JustBetter\AkeneoProducts\Exceptions\NotImplementedException;

class ProductModelRetriever extends BaseProductModelRetriever
{
    public function retrieve(string $code): ?ProductModelData
    {
        throw new NotImplementedException('Method "'.__FUNCTION__.'" has not been implemented');
    }
}
