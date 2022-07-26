<?php

namespace App\Core;

class Resource
{

    public static function render($resource, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = dirname(dirname(dirname(__FILE__))) . '/resources/' . $resource;

        if (is_readable($file)) {
            require_once $file;
        } else {
            throw new \Exception("$file not found");
        }
    }
}
