<?php

namespace JustBetter\AkeneoProducts;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use JustBetter\AkeneoProducts\Actions\Akeneo\CreateAttributeOption;
use JustBetter\AkeneoProducts\Actions\Akeneo\FormatAttributeValues;
use JustBetter\AkeneoProducts\Actions\Akeneo\GetAttribute;
use JustBetter\AkeneoProducts\Actions\Akeneo\GetAttributeOptions;
use JustBetter\AkeneoProducts\Actions\Akeneo\GetLocales;
use JustBetter\AkeneoProducts\Actions\Akeneo\GetScopes;
use JustBetter\AkeneoProducts\Actions\Akeneo\ResolveAttributeOption;
use JustBetter\AkeneoProducts\Actions\Product\ProcessProducts;
use JustBetter\AkeneoProducts\Actions\Product\RetrieveProduct;
use JustBetter\AkeneoProducts\Actions\Product\SaveProduct;
use JustBetter\AkeneoProducts\Actions\Product\UpdateProduct;
use JustBetter\AkeneoProducts\Commands\Product\ProcessProductsCommand;
use JustBetter\AkeneoProducts\Commands\Product\RetrieveProductCommand;
use JustBetter\AkeneoProducts\Commands\Product\UpdateProductCommand;

class ServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        $this
            ->registerConfig()
            ->registerActions();
    }

    protected function registerConfig(): static
    {
        $this->mergeConfigFrom(__DIR__.'/../config/akeneo-products.php', 'akeneo-products');

        return $this;
    }

    protected function registerActions(): static
    {
        ProcessProducts::bind();
        RetrieveProduct::bind();
        SaveProduct::bind();
        UpdateProduct::bind();

        CreateAttributeOption::bind();
        FormatAttributeValues::bind();
        GetAttribute::bind();
        GetAttributeOptions::bind();
        GetLocales::bind();
        GetScopes::bind();
        ResolveAttributeOption::bind();

        return $this;
    }

    public function boot(): void
    {
        $this
            ->bootConfig()
            ->bootMigrations()
            ->bootCommands();
    }

    protected function bootConfig(): static
    {
        $this->publishes([
            __DIR__.'/../config/akeneo-products.php' => config_path('akeneo-products.php'),
        ], 'config');

        return $this;
    }

    protected function bootMigrations(): static
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        return $this;
    }

    protected function bootCommands(): static
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ProcessProductsCommand::class,
                RetrieveProductCommand::class,
                UpdateProductCommand::class,
            ]);
        }

        return $this;
    }
}
