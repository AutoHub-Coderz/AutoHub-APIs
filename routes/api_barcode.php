<?php

use App\Router;

Router::group(['prefix' => '/v1'], function () {

    Router::group(['prefix' => '/barcode'], function () {

        Router::group(['middleware' => \App\Middlewares\ApiVerification::class], function () {
            Router::match(['get', 'post'], '/', 'BarCodeController@generate')->setName('barcode');
        });

        Router::match(['get', 'post'], '/help', function () {
            $response['parameters'] = array(
                'key' => array('required' => true, 'value' => 'string'),
                'data' => array('required' => true, 'value' => 'string'),
                'filename' => array('required' => false, 'value' => 'string'),
            );
            response()->json($response);
        })->setName('barcode.help');
    });
});
