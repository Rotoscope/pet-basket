<?php

namespace Core;

class Uri {

    public static function uri() {
        return $_SERVER['REQUEST_URI'];
    }

    public static function controller() {
        $uri = self::uri();
        $parts = explode('/', $uri);
        if (isset($parts[3]))
            return $parts[3];
        return false;
    }

    public static function action() {
        $uri = self::uri();
        $parts = explode('?', $uri);
        $uri = $parts[0];
        $parts = explode('/', $uri);
        if (isset($parts[4]))
            return $parts[4];
        return 'index';
    }

}
