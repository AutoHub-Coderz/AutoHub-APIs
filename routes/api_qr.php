<?php

use App\Router;

Router::group(['prefix' => '/v1'], function () {

    Router::group(['prefix' => '/qr'], function () {

        Router::group(['middleware' => \App\Middlewares\ApiVerification::class], function () {
            Router::match(['get', 'post'], '/', 'QRController@generate')->setName('qr');
        });

        Router::match(['get', 'post'], '/help', function () {
            $response['parameters'] = array(
                'key' => array('required' => true, 'value' => 'string'),
                'data' => array('required' => true, 'value' => 'string'),
                'label' => array('required' => false, 'value' => 'string'),
                'logo' => array('required' => false, 'value' => 'boolean'),
                'filename' => array('required' => false, 'value' => 'string'),
            );
            response()->json($response);
        })->setName('qr.help');
    });
});
