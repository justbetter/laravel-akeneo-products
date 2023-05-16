# Laravel Akeneo Products

<p>
    <a href="https://github.com/justbetter/laravel-akeneo-products"><img src="https://img.shields.io/github/actions/workflow/status/justbetter/laravel-akeneo-products/tests.yml?label=tests&style=flat-square" alt="Tests"></a>
    <a href="https://github.com/justbetter/laravel-akeneo-products"><img src="https://img.shields.io/github/actions/workflow/status/justbetter/laravel-akeneo-products/coverage.yml?label=coverage&style=flat-square" alt="Coverage"></a>
    <a href="https://github.com/justbetter/laravel-akeneo-products"><img src="https://img.shields.io/github/actions/workflow/status/justbetter/laravel-akeneo-products/analyse.yml?label=analysis&style=flat-square" alt="Analysis"></a>
    <a href="https://github.com/justbetter/laravel-akeneo-products"><img src="https://img.shields.io/packagist/dt/justbetter/laravel-akeneo-products?color=blue&style=flat-square" alt="Total downloads"></a>
</p>

Easily export products to Akeneo from your ERP.

This package is built to easily create products in Akeneo from your ERP or other (external) source, without the complexity of the different field types in Akeneo. The structure of attributes is all taken care of by the package. This means that a simple key-value array is already sufficient to start upserting products.

Aside from attributes, you can also set a family, categories and all other data you would normally be able to via the [API](https://api.akeneo.com/api-reference.html#Products).

> **Note:** This package does not have support for product models yet.

For more advanced use cases, it is also possible to add your own data to the payload.

Products are retrieved and updated in small chunks to spread the load if your project has access to a lot of products. Updates of these products are only sent to Akeneo if something has been modified to prevent unnecessary requests.

## Prerequisites

This package makes use of the [Akeneo Client](https://github.com/justbetter/laravel-akeneo-client). Make sure to follow it's README to install and configure it correctly.

## Installation

Install the composer package.

```bash
composer require justbetter/laravel-akeneo-products
```

## Setup

Publish the configuration of the package.

```bash
php artisan vendor:publish --provider="JustBetter\AkeneoProducts\ServiceProvider" --tag=config
```

Add the following command to your scheduler.

```php
<?php

use JustBetter\AkeneoProducts\Commands\ProcessProductsCommand;

$schedule->command(ProcessProductsCommand::class)->everyMinute();
```

## How it works

When a product is retrieved, it will fetch the product from the (external) source. If the retrieved data is not null, it will be saved in the database. If the payload of the model has been changed, the `update`-property of the model will be set to `true`. This way, the package is aware of updates and can do them in small batches. The numbers can be tweaked in your configuration file.

When a product has already been retrieved in the past, the `retrieve`-property of the model can be set to `true` in order to automatically fetch the data again. This is done by the `ProcessProductsCommand`, if added to your scheduler.

All products saved in the database will be processed under the following conditions:

1. If `retrieve` is set to `true`, the product will be fetched again from the (external) source.
2. If `update` is set to `true`, the product will be upserted to Akeneo.

This package does **not** contain a way to retrieve "all" products. If you wish to retrieve all products daily, you will have to dispatch the `RetrieveProductJob` with an identifier yourself.

```php
<?php

use JustBetter\AkeneoProducts\Jobs\RetrieveProductJob;

RetrieveProductJob::dispatch('::identifier::');
```

## Retrieving products

First, start by creating your own retriever as this is how the package will be interacting with the (external) source.

By building up a `ProductData` class, the package knows how to send this data to Akeneo.

**Make sure** you have set your retriever in the configuration file.

This package also ships with an `Attribute` model, which is meant to dynamically create the payload. We have also written a [Nova](https://github.com/justbetter/laravel-akeneo-products-nova) integration to make this even easier as it provides a mapping resource.

## Example

This is an example of how this package can be used, using a configured attribute mapping.

```php
<?php

use JustBetter\AkeneoProducts\Contracts\Akeneo\FormatsAttributeValues;
use JustBetter\AkeneoProducts\Data\ProductData;
use JustBetter\AkeneoProducts\Enums\MappingType;
use JustBetter\AkeneoProducts\Models\Mapping;
use JustBetter\AkeneoProducts\Retrievers\BaseRetriever;

class ExampleRetriever extends BaseRetriever
{
    public function __construct(
        protected FormatsAttributeValues $formatValue
    ) {
    }

    public function retrieve(string $identifier): ?ProductData
    {
        // Get all configured attributes from the database.
        $attributes = Mapping::of(MappingType::Attribute)->get();

        // This would be the product fetched from an ERP system.
        $product = [
            'SKU' => '1000',
            'Title' => 'Ziggy',
            'Category_Code' => 'STUFFED_TOYS',
            // ...
        ];

        // Build up the "values" array for Akeneo.
        $values = [
            //
        ];

        foreach ($product as $key => $value) {
            /** @var ?Mapping $mapped */
            $mapped = $attributes->firstWhere('source', '=', $key);

            if ($mapped === null || $value === null) {
                continue;
            }

            // Format the raw value into an appropriate attribute value for Akeneo.
            $data = $this->formatValue->format($mapped->destination, $value);

            // Add the value to the list, with the Akeneo field as the key.
            $values[$mapped->destination] = $data;
        }

        $data = [
            'identifier' => $identifier,
            'values' => $values,
        ];

        $family = Mapping::get(MappingType::Family, $product['Category_Code']);

        // Optionally, add a family. Note that you can also add categories.
        if ($family) {
            $data['family'] = $family->destination;
        }

        return ProductData::of($data);
    }
}
```

## Supported attribute types

Currently, the following attribute types are supported by this package:

- `pim_catalog_text`
- `pim_catalog_textarea`
- `pim_catalog_number`
- `pim_catalog_metric`
- `pim_catalog_boolean`
- `pim_catalog_price_collection`
- `pim_catalog_simpleselect`

## Commands

This package ships with a few commands.

Retrieve a product by it's identifier, it will automatically be saved to the database.

```bash
php artisan akeneo-products:retrieve {identifier}
```

Process all products, this includes retrieving and updating products.

```bash
php artisan akeneo-products:process
```

Update a product by it's identifier. This will manually trigger an update towards Akeneo, regardless if the product is up-to-date.

```bash
php artisan akeneo-products:update {identifier}
```

## Quality

To ensure the quality of this package, run the following command:

```bash
composer quality
```

This will execute three tasks:

1. Makes sure all tests are passed
2. Checks for any issues using static code analysis
3. Checks if the code is correctly formatted

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Ramon Rietdijk](https://github.com/ramonrietdijk)
- [Vincent Boon](https://github.com/VincentBean)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
