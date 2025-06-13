<?php

return [
    'default' => env('CAPTCHA_DEFAULT_DRIVER', 'normalImage'),

    'normalImage' => [
        'characters' => ['2', '3', '4', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'j', 'm', 'n', 'p', 'q', 'r', 't', 'u', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'M', 'N', 'P', 'Q', 'R', 'T', 'U', 'X', 'Y', 'Z'],
        'length' => 4,          // 验证码长度
        'width' => 120,
        'height' => 36,
        'quality' => 90,
        'expire' => 600,        // 过期时间，单位为秒
        'sensitive' => false,   // 是否区分大小写
        'encrypt' => false,
        'lines' => 1,           // 干扰线数量
    ],

    'mathImage' => [
        'length' => 9,  // 数学式子长度，此处固定为9
        'width' => 120,
        'height' => 36,
        'quality' => 90,
        'math' => true,
        'expire' => 600,
    ],

    // 腾讯云行为验证码
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
        'smsDriver' => 'serviceDemoApp',  // sms.drivers.xxx
        // 验证码配置
        'captcha' => [
            'characters' => ['0'],
            'length' => 6,   // 验证码长度
            'expire' => 300, // 验证码有效期，单位为秒
            'maxAttempts' => 5, // 最大尝试次数
            'reuseable' => false, // 在有效期内是否可重用验证码
        ],
    ],
];