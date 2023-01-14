<?php

namespace Donmbelembe\LaravelFacebookCatalog;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Donmbelembe\LaravelFacebookCatalog\Commands\LaravelFacebookCatalogCommand;

class LaravelFacebookCatalogServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-facebook-catalog')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-facebook-catalog_table')
            ->hasCommand(LaravelFacebookCatalogCommand::class);
    }
}
