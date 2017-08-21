<?php


namespace Portal\Tools;


class App
{
    private static $registry = [];

    public static function add($key, $value)
    {
        static::$registry[$key] = $value;
    }

    public static function get($key)
    {
        if ( ! array_key_exists($key, static::$registry)) {
            throw new Exception("No {$key} is bound in the container.");
        }

        return static::$registry[$key];
    }

    public static function getRegistry()
    {
        return static::$registry;
    }

}