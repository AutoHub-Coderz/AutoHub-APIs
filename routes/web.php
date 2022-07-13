<?php

use App\Router;


Router::get('/test', 'TestController@test')->setName('test');

Router::group(['middleware' => \App\Middlewares\Auth::class], function () {
    Router::group(['middleware' => \App\Middlewares\Admin::class], function () {
        Router::get('/', 'DefaultController@mainIndex')->setName('main');
    });

    Router::get('/user_access', function () {
        echo "Not admin";
    })->setName('user.access');
});
Router::get('/info', function () {
    phpinfo();
})->setName('info');


Router::get('/mysql', function () {
    // new mysqli($config['host'], $config['username'], $config['password'], $config['database']);


    $mysqli = new mysqli("localhost", "autoph_api", "wefS[rLyuB.{", "autoph_api");

    // Check connection
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    } else {
        echo "Connected to MySQL: " . $mysqli->connect_error;
        exit();
    }
})->setName('info');
