<?php

return [
    'default' => env('SMS_DRIVER', 'tencentCloudApp'),

    'drivers' => [
        // 
        'tencentCloudApp' => [
            'service' => 'tencentCloud', // 腾讯云短信服务

            // 云平台配置
            'platform' => [
                'secretId' => env('TENCENT_CLOUD_SECRET_ID'),
                'secretKey' => env('TENCENT_CLOUD_SECRET_KEY'),
                'region' => env('TENCENT_CLOUD_REGION', 'ap-guangzhou'),
            ],
            // 应用配置
            'app' => [
                'appId' => env('TENCENT_CLOUD_SMS_APP_ID'),
                'sign' => env('TENCENT_CLOUD_SMS_SIGN'),
                'templateId' => env('TENCENT_CLOUD_SMS_TEMPLATE_ID'),
            ]
        ],

        'txApp1' => [
            'service' => 'tencentCloud', // 腾讯云短信服务
            'platform' => [
                'secretId' => env('TENCENT_CLOUD_SECRET_ID'),
                'secretKey' => env('TENCENT_CLOUD_SECRET_KEY'),
                'region' => env('TENCENT_CLOUD_REGION', 'ap-guangzhou'),
            ],
            'app' => [
                'appId' => 'app1',
                'sign' => '签名',
                'templateId' => '1',
            ]
        ],

        'serviceDemoApp' => [
            'service' => 'serviceDemo',

            'k1' => 'v1',
        ],

        'driverDemo' => [
            'k1' => 'v1',
        ],
    ],
];
