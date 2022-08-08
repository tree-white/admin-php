<?php

namespace App\Services;

use Overtrue\EasySms\EasySms;

class SmsService
{
    /**
     * @description: 发送手机验证码
     * @param {*} $phone 手机号
     * @param {string} $templateCode 模版
     * @param {string} $templateParam 参数
     * @return {*}
     */
    public function send($phone, string $templateCode, array $templateParam)
    {
        $sms = new EasySms($this->config());
        return $sms->send($phone, [
            // 短信模版
            'template' => $templateCode,
            // 模版变量
            'data' => $templateParam
        ]);
    }

    protected function config()
    {
        return
            [
                // HTTP 请求的超时时间（秒）
                'timeout' => 5.0,

                // 默认发送配置
                'default' => [
                    // 网关调用策略，默认：顺序调用
                    'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

                    // 默认可用的发送网关
                    'gateways' => [
                        'aliyun',
                    ],
                ],
                // 可用的网关配置
                'gateways' => [
                    'errorlog' => [
                        'file' => '/tmp/easy-sms.log',
                    ],
                    'aliyun' => [
                        'access_key_id' => config('system.aliyun.access_key_id'),
                        'access_key_secret' => config('system.aliyun.access_key_secret'),
                        'sign_name' => config('system.aliyun.sms.sign_name'),
                    ],
                ],
            ];
    }
}
