<?php

declare(strict_types=1);

namespace JustBetter\AkeneoProducts\Tests\Fakes\Retrievers\Product;

use JustBetter\AkeneoProducts\Data\ProductData;
use JustBetter\AkeneoProducts\Retrievers\Product\BaseProductRetriever;

class EmptyProductRetriever extends BaseProductRetriever
{
    public function retrieve(string $identifier): ?ProductData
    {
        return null;
    }
}
