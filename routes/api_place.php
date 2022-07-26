<?php

use App\Router;

Router::group(['prefix' => '/v1'], function () {

    Router::group(['prefix' => '/place'], function () {

        Router::group(['middleware' => \App\Middlewares\ApiVerification::class], function () {
            Router::match(['get', 'post'], '/', 'PlaceController@place')->setName('place');
        });

        Router::match(['get', 'post'], '/help', function () {
            $response['parameters'] = array(
                'key' => array('required' => true, 'value' => 'string'),
                'data' => array('required' => true, 'value' => 'string'),
            );
            response()->json($response);
        })->setName('place.help');
    });
});
