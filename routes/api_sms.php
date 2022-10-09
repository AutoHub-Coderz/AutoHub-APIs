<?php

use App\Router;


Router::group(['prefix' => '/v1'], function () {
    Router::group(['prefix' => '/sms'], function () {
        Router::group(['middleware' => \App\Middlewares\ApiVerification::class], function () {
            Router::match(['get', 'post'], '/{sms}', function ($sms) {
                // echo $sms;
                // exit;

                if (empty(input('mobile'))) {
                    response()->json(array("status" => 0, "message" => "mobile parameter is required."));
                }
                if (empty(input('message'))) {
                    response()->json(array("status" => 0, "message" => "message parameter is required."));
                }

                // //next line to break  
                // $message = strtr(input('message'), array("\n" => "\\n"));
                // //remove non ascii
                // $message = \App\Utilities\Utility::removeNonAscii($message);
                // //remove extra space
                // $message = \App\Utilities\Utility::removeExtraSpace($message); 
                // $message = strtr(input('message'), array("\n" => "\\n"));

                $message = \App\Utilities\Utility::cleanString(input('message'));
                // $message = escape($message);
                $message = addslashes($message);
                $message = strtr($message, array("\n" => "\\n",  "\r" => ""));

                $sms_config = (object) config('sms')->{$sms};

                $replace_parameter = array(
                    '{mobile}' => input('mobile'),
                    '{message}' => $message,
                );

                $payload = is_array($sms_config->payload) ? json_encode($sms_config->payload) : $sms_config->payload;
                $parameters = strtr($payload, $replace_parameter);
                $parameters =  is_array($sms_config->payload) ?  http_build_query(json_decode($parameters, true)) : $parameters;

                $array_data['uri'] = $sms_config->uri;
                $array_data['parameters'] = $parameters;
                $array_data['header'] = $sms_config->http_header;

                $result = \App\Utilities\Utility::curl($array_data);

                $status = 0;
                switch ($sms_config->response['type']) {
                    case 'json':
                        $result_arr = json_decode($result, true);
                        if ($result_arr[$sms_config->response['key']] == $sms_config->response['success']) {
                            $status = 1;
                        }
                        break;
                    case 'text':
                        if (\App\Utilities\Utility::cleanString($result) == $sms_config->response['success']) {
                            $status = 1;
                        }
                        break;
                    default:
                        $status = 1;
                }
                response()->json(array("status" => $status, "response" => $result));

                // response()->json(array("response" => $result));
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
