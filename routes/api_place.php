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
                'country' => array('required' => false, 'value' => 'int|string', 'description' => 'id or iso2 of country'),
                'state' => array('required' => false, 'required_params' => 'country', 'value' => 'boolean|int|string', 'description' => 'boolean to display country states, id or state_code of state'),
                'city' => array('required' => false, 'required_params' => 'country|state', 'value' => 'boolean', 'description' => 'boolean to display all city under of given state and country'),
            );
            response()->json($response);
        })->setName('place.help');
    });
});
