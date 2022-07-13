<?php

use App\Router;

Router::get('/key', function () {
    response()->json(array("token" => str_replace('-', '', \App\Utilities\Token::generate())));
})->setName('key');
