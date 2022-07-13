<?php

namespace App\Core;

class Sms
{

    public static function send($array_data)
    {

        if (empty($array_data['mobile']) && empty($array_data['message'])) {
            return "Mobile and Message are required.";
        }

        //clean message
        // $args['message'] = strtr($args['message'], array("\n" => "\\n",  "\r" => "\\r"));
        $args['message'] = strtr($args['message'], array("\n" => "\\n"));
        //remove non utf8 character
        $args['message'] = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $args['message']);

        $replace_parameter = array(
            '[no]' => $args['mobile'],
            '[msg]' => $args['message'],
            '[key]' => SMS_KEY,
            '[pwd]' => SMS_PASSWORD,
        );

        $final_template = strtr(SMS_BODY, $replace_parameter);


        // if ($args['mobile'] == '+639771424322') {
        //     print_r($final_template);
        //     exit;
        // }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, SMS_URI);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_decode($final_template, true));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $final_template);
        if (count(SMS_HEADER) > 0) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, SMS_HEADER);
        }

        $result = curl_exec($ch);

        // return $result;
        $response  = json_decode($result, true);

        // return $response;
        return $response['status'] == 201 ? 0 : $result;
    }
}
