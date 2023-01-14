<?php

namespace Donmbelembe\LaravelFacebookCatalog;

class LaravelFacebookCatalog
{
    public static $container = null;

    public static function container()
    {
        if (is_null(static::$container)) {
            static::$container = new Feed;
        }

        return static::$container;
    }

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([static::container(), $name], $arguments);
    }
}
