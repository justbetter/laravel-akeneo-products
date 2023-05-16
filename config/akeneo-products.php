<?php

return [

    /* Determines which queue jobs should be dispatched on. */
    'queue' => 'default',

    /* Max tries before a product sync will automatically be turned off. */
    'tries' => 3,

    /* Amount of products to be retrieved at once when processing. */
    'retrieve_batch_size' => 100,

    /* Amount of products to be updated at once when processing. */
    'update_batch_size' => 25,

    /* Class responsible to retrieve the products from. */
    'retriever' => \JustBetter\AkeneoProducts\Retrievers\ProductRetriever::class,

];
