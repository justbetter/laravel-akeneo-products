<?php

use JustBetter\AkeneoProducts\Retrievers\Product\ProductRetriever;
use JustBetter\AkeneoProducts\Retrievers\ProductModel\ProductModelRetriever;

return [

    /* Determines which queue jobs should be dispatched on. */
    'queue' => 'default',

    /* Configuration for the retrievers. */
    'retrievers' => [

        /* Class responsible to retrieve the products from. */
        'product' => ProductRetriever::class,

        /* Class responsible to retrieve the product models from. */
        'product_model' => ProductModelRetriever::class,
    ],
];
