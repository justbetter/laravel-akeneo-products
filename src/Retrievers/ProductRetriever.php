<?php

namespace JustBetter\AkeneoProducts\Retrievers;

use JustBetter\AkeneoProducts\Data\ProductData;
use JustBetter\AkeneoProducts\Exceptions\NotImplementedException;

class ProductRetriever extends BaseRetriever
{
    public function retrieve(string $identifier): ?ProductData
    {
        throw new NotImplementedException('Method "'.__FUNCTION__.'" has not been implemented');
    }
}
