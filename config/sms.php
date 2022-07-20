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
        'uri' => 'https://www.itexmo.com/php_api/api.php',
        'payload' => [
            "1" => "{mobile}",
            "2" => "{message}",
            "3" => "PR-AUTOH172111_IE74I",
            "passwd" => "me}vfe3j#c",
            "5" => "HIGH",
        ],
        'http_header' => ["Content-Type: application/x-www-form-urlencoded"],
        'response' => [
            "type" => "text",
            "key" => "",
            "success" => "0",
        ],
    ],
];
