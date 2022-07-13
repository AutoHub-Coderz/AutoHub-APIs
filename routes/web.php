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
    $con = mysqli_connect("localhost", "my_user", "my_password", "my_db");

    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    } else {
        echo "Connected to MySQL";
        exit();
    }
})->setName('mysql');
