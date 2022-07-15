<?php

return [
    'default' => [
        'uri' => 'https://api.philsms.com/outbound/v1',
        'payload' => '{
            "apiKey" : "aenda-5XRDT",
            "apiPass" : "3[#kQ.Rx~E",
            "mask" : "AUTOHUB GRP",
            "content" : "{message}",
            "msisdn" : "{mobile}"
        }',
        'http_header' => ["Content-Type: application/json"],
        'response' => [
            "type" => "json",
            "key" => "status",
            "success" => "201",
        ],
    ],
    'golf' => [
        'uri' => 'https://api.philsms.com/outbound/v1',
        'payload' => '{
            "apiKey" : "aenda-5XRDT",
            "apiPass" : "3[#kQ.Rx~E",
            "mask" : "101010GOLF",
            "content" : "{message}",
            "msisdn" : "{mobile}"
        }',
        'http_header' => ["Content-Type: application/json"],
        'response' => [
            "type" => "json",
            "key" => "status",
            "success" => "201",
        ],
    ],
    'itextmo' => [
        'uri' => '',
        'payload' => [],
        'http_header' => [],
        'response' => [
            "type" => "text",
            "key" => "",
            "success" => "0",
        ],
    ],
];
