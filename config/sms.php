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
    ],
    'itextmo' => [
        'uri' => '',
        'payload' => [],
        'http_header' => [],
    ],
];
