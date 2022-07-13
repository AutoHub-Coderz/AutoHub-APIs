<?php

use App\Router;


Router::group(['prefix' => '/v1'], function () {
    Router::group(['prefix' => '/sms'], function () {
        Router::group(['middleware' => \App\Middlewares\ApiVerification::class], function () {
            Router::match(['get', 'post'], '/', function () {
                if (empty(input('mobile'))) {
                    response()->json(array("status" => 0, "message" => "mobile parameter is required."));
                }
                if (empty(input('message'))) {
                    response()->json(array("status" => 0, "message" => "message parameter is required."));
                }

                //next line to break  
                $message = strtr(input('message'), array("\n" => "\\n"));
                //remove non ascii
                $message = \App\Utilities\Utility::removeNonAscii($message);
                //remove extra space
                $message = \App\Utilities\Utility::removeExtraSpaces($message);

                // echo $message;
                $sms_config = (object) config('sms')->{config('sms')->driver};

                $replace_parameter = array(
                    '{mobile}' => input('mobile'),
                    '{message}' => $message,
                );

                $payload = is_array($sms_config->payload) ? json_encode($sms_config->payload) : $sms_config->payload;
                $final_template = strtr($payload, $replace_parameter);
                $final_template =  is_array($sms_config->payload) ?  json_decode($final_template, true) : $final_template;

                // print_r($final_template);
                // exit;

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $sms_config->uri);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $final_template);
                if (count($sms_config->http_header) > 0) {
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $sms_config->http_header);
                }

                $result = curl_exec($ch);
                response()->json(array("response" => $result));
            })->setName('sms');
        });

        Router::match(['get', 'post'], '/help', function () {
            $response['parameters'] = array(
                'key' => array('required' => true, 'value' => 'string'),
                'mobile' => array('required' => true, 'value' => 'string|array'),
                'message' => array('required' => true, 'value' => 'string'),
            );
            response()->json($response);
        })->setName('sms.help');
    });
});
