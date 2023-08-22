<?php

return [

    /* Determines which queue jobs should be dispatched on. */
    'queue' => 'default',

    /* Configuration for the retrievers. */
    'retrievers' => [

        /* Class responsible to retrieve the products from. */
        'product' => \JustBetter\AkeneoProducts\Retrievers\Product\ProductRetriever::class,

        /* Class responsible to retrieve the product models from. */
        'product_model' => \JustBetter\AkeneoProducts\Retrievers\ProductModel\ProductModelRetriever::class,
    ],
];
