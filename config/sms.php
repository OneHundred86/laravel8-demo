<?php

return [
    'default' => env('SMS_DRIVER', 'tencentCloud'),

    'drivers' => [
        // 腾讯云短信服务
        'tencentCloud' => [
            'defaultApp' => 'default',    // 默认应用

            // 云平台配置
            'platform' => [
                'secretId' => env('TENCENT_CLOUD_SECRET_ID'),
                'secretKey' => env('TENCENT_CLOUD_SECRET_KEY'),
                'region' => env('TENCENT_CLOUD_REGION', 'ap-guangzhou'),
            ],

            // 应用配置
            'apps' => [
                'default' => [
                    'appId' => env('TENCENT_CLOUD_SMS_APP_ID'),
                    'sign' => env('TENCENT_CLOUD_SMS_SIGN'),
                    'templateId' => env('TENCENT_CLOUD_SMS_TEMPLATE_ID'),
                ]
            ],
        ],
    ],
];
