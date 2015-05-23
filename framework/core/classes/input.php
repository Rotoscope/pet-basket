<?php

namespace Core;

class Input {

    public static function get() {
        return filter_input_array(INPUT_GET);
    }

    public static function post() {
        return filter_input_array(INPUT_POST);
    }

    public static function files() {
        return $_FILES;
    }

}
