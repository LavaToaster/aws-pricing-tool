<?php

namespace Lavoaster\AWSClientPricing;

class Config
{
    private static $config = [];

    public static function setConfig(array $config)
    {
        static::$config = $config;
    }

    public static function get($key, $default = null)
    {
        return array_get(static::$config, $key, $default);
    }

    public static function set($key, $value)
    {
        array_set(static::$config, $key, $value);
    }
}
