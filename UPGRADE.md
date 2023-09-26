# Upgrading

Documentation about upgrading to the next major version.

## From 1.x to 2.x

Since version 2.x, support for product models has been added. By doing so, most classes have been moved to a new namespace. The configuration is also mostly moved to the retriever class itself.

### Namespaces

The retriever class for products has also been changed. Please, update all references to the new namespace.

```php
use JustBetter\AkeneoProducts\Retrievers\BaseRetriever;

// Is now

use JustBetter\AkeneoProducts\Retrievers\Product\BaseProductRetriever;
```

All classes related to products have also been moved within the `Product` namespace. This applies to `Actions`, `Jobs`, `Commands`, etc. Make sure to update all references as well.

Example:

```php
use JustBetter\AkeneoProducts\Jobs\RetrieveProductJob;

// Is now

use JustBetter\AkeneoProducts\Jobs\Product\RetrieveProductJob;
```

### Configuration

In order to have a more dynamic configuration, the options have been moved to the retriever class itself. If you wish to configure the batch sizes or the amount of tries, add these properties to your retriever class.
