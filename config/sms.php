<?php

return [
    'driver' => 'philsms',
    'philsms' => [
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
    'itextmo' => [
        'uri' => '',
        'payload' => [],
        'http_header' => [],
    ],
];
