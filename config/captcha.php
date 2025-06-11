<?php

return [
    'default' => env('CAPTCHA_DEFAULT_DRIVER', 'image'),

    'image' => [
        'type' => 'default',    // 默认验证码类型，default|math|flat|mini|inverse
        'characters' => ['2', '3', '4', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'j', 'm', 'n', 'p', 'q', 'r', 't', 'u', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'M', 'N', 'P', 'Q', 'R', 'T', 'U', 'X', 'Y', 'Z'],
        'default' => [
            'length' => 4,          // 验证码长度
            'width' => 120,
            'height' => 36,
            'quality' => 90,
            'expire' => 600,        // 过期时间，单位为秒
            'sensitive' => false,   // 是否区分大小写
            'encrypt' => false,
        ],
        'math' => [
            'length' => 9,
            'width' => 120,
            'height' => 36,
            'quality' => 90,
            'math' => true,
            'expire' => 600,
        ],

        'flat' => [
            'length' => 6,
            'width' => 160,
            'height' => 46,
            'quality' => 90,
            'lines' => 6,
            'bgImage' => false,
            'bgColor' => '#ecf2f4',
            'fontColors' => ['#2c3e50', '#c0392b', '#16a085', '#c0392b', '#8e44ad', '#303f9f', '#f57c00', '#795548'],
            'contrast' => -5,
            'expire' => 600,
        ],
        'mini' => [
            'length' => 3,
            'width' => 60,
            'height' => 32,
            'expire' => 600,
        ],
        'inverse' => [
            'length' => 5,
            'width' => 120,
            'height' => 36,
            'quality' => 90,
            'sensitive' => true,
            'angle' => 12,
            'sharpen' => 10,
            'blur' => 2,
            'invert' => true,
            'contrast' => -5,
            'expire' => 600,
        ]
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