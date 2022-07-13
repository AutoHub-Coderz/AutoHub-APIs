<?php

use App\Router;

Router::group(['prefix' => '/api'], function () {
    Router::get('/include', function () {
        print_r(config('qr')->logo);
    })->setName('sms');

    Router::group(['prefix' => '/sms'], function () {
        Router::get('/', function () {
            echo "sms";
        })->setName('sms');
    });

    Router::group(['prefix' => '/qr'], function () {
        Router::get('/', "QRController@generate")->setName('qr');
        Router::get('/help', function () {
            echo "data";
            echo "<br>";
            echo "label";
            echo "<br>";
            echo "logo";
            echo "<br>";
            echo "filename";
            echo "<br>";
        })->setName('qr');
    });
});
