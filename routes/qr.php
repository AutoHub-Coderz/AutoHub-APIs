<?php

use App\Router;

Router::group(['middleware' => \App\Middlewares\ApiVerification::class], function () {
    Router::group(['prefix' => '/v1'], function () {

        Router::group(['prefix' => '/sms'], function () {
            Router::get('/', function () {
                echo "sms";
            })->setName('sms');
        });

        Router::group(['prefix' => '/qr'], function () {
            Router::get('/', "QRController@generate")->setName('qr');
            Router::get('/help', function () {
                $response['parameters'] = array(
                    'data' => array('required' => true, 'value' => 'string'),
                    'label' => array('required' => false, 'value' => 'string'),
                    'logo' => array('required' => false, 'value' => 'boolean'),
                    'filename' => array('required' => false, 'value' => 'string'),
                );
                response()->json($response);
            })->setName('qr');
        });
    });
});
