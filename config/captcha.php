<?php

return [
    'default' => env('CAPTCHA_DEFAULT_DRIVER', 'image'),

    'image' => [
        'default' => 'normal',    // 默认验证码类型，normal | math
        'normal' => [
            'characters' => ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c'],
            'length' => 4,          // 验证码长度
            'width' => 120,
            'height' => 36,
            'quality' => 90,
            'expire' => 600,        // 过期时间，单位为秒
            'sensitive' => false,   // 是否区分大小写
            'encrypt' => false,
            'lines' => 1,         // 干扰线数量
        ],
        'math' => [
            'length' => 9,
            'width' => 120,
            'height' => 36,
            'quality' => 90,
            'math' => true,
            'expire' => 600,
        ],
    ],

    'tencentCloud' => [
        'secret_id' => env('TENCENT_CLOUD_SECRET_ID'),
        'secret_key' => env('TENCENT_CLOUD_SECRET_KEY'),
        'region' => env('TENCENT_CLOUD_REGION', 'ap-guangzhou'),
        'captcha_app' => [
            'app_id' => (int) env('TENCENT_CLOUD_CAPTCHA_APP_ID'),
            'secret_key' => env('TENCENT_CLOUD_CAPTCHA_SECRET_KEY'),
        ],
    ],

    // 短信验证码
    'sms' => [
        'default' => 'tencentCloud',  // 默认使用的短信服务驱动

        // 验证码配置
        'characters' => ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
        'length' => 6,
        'expire' => 300, // 验证码有效期，单位为秒
        'max_attempts' => 5, // 最大尝试次数
        'reuseable' => true, // 是否可重用验证码

        // 腾讯云短信验证码
        'tencentCloud' => [
            'secret_id' => env('TENCENT_CLOUD_SECRET_ID'),
            'secret_key' => env('TENCENT_CLOUD_SECRET_KEY'),
            'region' => env('TENCENT_CLOUD_REGION', 'ap-guangzhou'),
            'sms_app' => [
                'app_id' => env('TENCENT_CLOUD_SMS_APP_ID'),
                'sign' => env('TENCENT_CLOUD_SMS_SIGN'),
                'template_id' => env('TENCENT_CLOUD_SMS_TEMPLATE_ID'),
            ],
        ],
    ],
];