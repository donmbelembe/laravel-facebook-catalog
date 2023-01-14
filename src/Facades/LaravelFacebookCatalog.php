<?php

namespace Donmbelembe\LaravelFacebookCatalog\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Donmbelembe\LaravelFacebookCatalog\LaravelFacebookCatalog
 */
class LaravelFacebookCatalog extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Donmbelembe\LaravelFacebookCatalog\LaravelFacebookCatalog::class;
    }
}
