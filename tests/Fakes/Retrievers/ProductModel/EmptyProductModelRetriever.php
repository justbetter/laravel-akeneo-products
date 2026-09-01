<?php

declare(strict_types=1);

namespace JustBetter\AkeneoProducts\Tests\Fakes\Retrievers\ProductModel;

use JustBetter\AkeneoProducts\Data\ProductModelData;
use JustBetter\AkeneoProducts\Retrievers\ProductModel\BaseProductModelRetriever;

class EmptyProductModelRetriever extends BaseProductModelRetriever
{
    public function retrieve(string $code): ?ProductModelData
    {
        return null;
    }
}
