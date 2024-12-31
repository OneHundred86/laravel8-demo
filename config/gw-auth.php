<?php

return [
    'private-requests' => [
        'admin' => [
            'app' => env('GW_AUTH_PRIVATE_APP', 'app1'),
            'ticket' => env('GW_AUTH_PRIVATE_TICKET', 'ticket1'),
        ],
    ],
];