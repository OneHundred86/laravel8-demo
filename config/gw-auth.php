<?php

return [
    'private-requests' => [
        'gw' => [
            'app' => env('GW_AUTH_PRIVATE_APP', 'app1'),
            'ticket' => env('GW_AUTH_PRIVATE_TICKET', 'ticket123'),
            'ignore-check' => env('APP_DEBUG', false),  // 是否忽略校验
        ],
    ],
];