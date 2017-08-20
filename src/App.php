<?php


namespace Portal\Tools;


class App
{
    private static $registry = [];

    public static function add($key, $value) {
        static::$registry[$key] = $value;
    }

    public static function get($key) {
        return static::$registry[$key];
    }
}