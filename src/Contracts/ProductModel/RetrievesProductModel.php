<?php

declare(strict_types=1);

namespace JustBetter\AkeneoProducts\Contracts\ProductModel;

interface RetrievesProductModel
{
    public function retrieve(string $code): void;
}
