<?php

namespace JustBetter\AkeneoProducts\Contracts\ProductModel;

interface RetrievesProductModel
{
    public function retrieve(string $code): void;
}
