<?php

use App\Router;

Router::get('/getkey', function () {
    response()->json(array("token" => str_replace('-', '', \App\Utilities\Token::generate())));
})->setName('getkey');
