<?php

return [
    'mobile' => '15820153724',
    'code_expire_time' => env('CODE_EXPIRE_TIME', 10),
    'aliyun' => [
        'access_key_id' => env('ALIYUN_ACCESS_KEY_ID'),
        'access_key_secret' => env('ALIYUN_ACCESS_KEY_SECRET'),
        'sign_name' => env('ALIYUN_SMS_SIGN_NAME'),
    ]
];
