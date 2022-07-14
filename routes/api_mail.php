<?php

use App\Router;

Router::group(['prefix' => '/v1'], function () {

    Router::group(['prefix' => '/mail'], function () {

        Router::group(['middleware' => \App\Middlewares\ApiVerification::class], function () {
            Router::match(['get', 'post'], '/', function () {

                if (empty(input('data'))) {
                    response()->json(array("status" => 0, "message" => "data parameter is required."));
                }

                $array_data = json_decode(input('data'), true);
                // $array_data =   array(
                //     "from" => ["email" => "from@email.com", "name" => "From Me"],
                //     "recipient" =>
                //     [
                //         ["email" => "candaya@autohubgroup.com", "name" => "Clarence Andaya"],
                //     ],
                //     "reply_to" => ["email" => "reply_to@email.com", "name" => "Reply To"],
                //     "cc" => ["cc1@email.com", "cc2@email.com", "cc3@email.com"],
                //     "bcc" => ["bcc1@email.com", "bcc2@email.com", "bcc3@email.com"],
                //     "subject" => "Subject",
                //     "message" => "Message Content",
                // );

                // print_r(json_encode($array_data));
                // exit;

                \App\Core\Mail::sendMail($array_data);
            })->setName('mail');
        });

        Router::match(['get', 'post'], '/help', function () {
            $response['parameters'] = array(
                'key' => array('required' => true, 'value' => 'string'),
                'data' =>  array(
                    "from" => ["email" => "from@email.com", "name" => "From Me"],
                    "recipient" =>
                    [
                        ["email" => "candaya@autohubgroup.com", "name" => "Clarence Andaya"],
                    ],
                    "reply_to" => ["email" => "reply_to@email.com", "name" => "Reply To"],
                    "cc" => ["cc1@email.com", "cc2@email.com", "cc3@email.com"],
                    "bcc" => ["bcc1@email.com", "bcc2@email.com", "bcc3@email.com"],
                    "subject" => "Subject",
                    "message" => "Message Content",
                ),
            );

            response()->json($response);
        })->setName('mail.help');
    });
});
