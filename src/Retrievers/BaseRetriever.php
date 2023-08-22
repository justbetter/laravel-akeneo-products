<?php

namespace JustBetter\AkeneoProducts\Retrievers;

abstract class BaseRetriever
{
    /* Max tries before a resource sync will automatically be turned off. */
    protected int $tries = 3;

    /* Amount of resources to be retrieved at once when processing. */
    protected int $retrieveBatchSize = 100;

    /* Amount of resources to be updated at once when processing. */
    protected int $updateBatchSize = 25;

    public function tries(): int
    {
        return $this->tries;
    }

    public function retrieveBatchSize(): int
    {
        return $this->retrieveBatchSize;
    }

    public function updateBatchSize(): int
    {
        return $this->updateBatchSize;
    }
}
