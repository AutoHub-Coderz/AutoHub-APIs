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

    if (input('driver') == 'pdo') {
        $mysqli = new mysqli("localhost", "autoph_api", "wefS[rLyuB.{", "autoph_api");

        // Check connection
        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli->connect_error;
            exit();
        } else {
            echo "Connected to MySQL: ";
            var_dump($mysqli);
            exit();
        }
    } else 
    if (input('driver') == 'mysql') {
        $servername = "localhost";
        $username = "autoph_api";
        $password = "wefS[rLyuB.{";
        $database = "autoph_api";

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $database);

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        echo "Connected successfully";
    }
})->setName('info');
