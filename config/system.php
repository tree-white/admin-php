<?php

return [
    'site' => [
        "title" => '楷欧巴',
        "logo" => '',
        "copyright" => "Trwite@楷哥哥 版权信息@版权所有"
    ],
    'code' => [
        'expire' => env('CODE_EXPIRE_TIME', 600), // 有效期 10分钟
        'timeout' => env('CODE_TIMEOUT_TIME', 60), // 超时时间 1分钟
        'length' => env('CODE_LENGTH', 6), // 验证码长度
    ],
    'aliyun' => [
        'access_key_id' => env('ALIYUN_ACCESS_KEY_ID'),
        'access_key_secret' => env('ALIYUN_ACCESS_KEY_SECRET'),
        'sign_name' => env('ALIYUN_SMS_SIGN_NAME'),
    ],
    'avatar' => [
        'avatar_crop_width' => env('AVATAR_CROP_WIDTH', 200),
        'avatar_crop_height' => env('AVATAR_CROP_HEIGHT', 200),
    ]
];
