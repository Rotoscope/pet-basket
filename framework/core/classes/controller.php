<?php

namespace Core;

class Controller {

    public static function _call($action) {
        // TODO
        // Must check that $action exists to prevent fatal error
        return static::$action();
    }

}
