<?php

use App\Router;

Router::group(['prefix' => '/api'], function () {
    Router::group(['prefix' => '/sms'], function () {
        Router::get('/', function () {
            echo "sms";
        })->setName('sms');
    });

    Router::group(['prefix' => '/qr'], function () {
        Router::get('/', "QRController@generate")->setName('qr');
    });
});
