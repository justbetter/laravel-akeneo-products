<?php

declare(strict_types=1);

namespace JustBetter\AkeneoProducts\Retrievers\Product;

use JustBetter\AkeneoProducts\Data\ProductData;
use JustBetter\AkeneoProducts\Exceptions\NotImplementedException;

class ProductRetriever extends BaseProductRetriever
{
    public function retrieve(string $identifier): ?ProductData
    {
        throw new NotImplementedException('Method "'.__FUNCTION__.'" has not been implemented');
    }
}
