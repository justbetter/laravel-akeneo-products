<?php

namespace JustBetter\AkeneoProducts\Contracts;

interface RetrievesProduct
{
    public function retrieve(string $identifier): void;
}
