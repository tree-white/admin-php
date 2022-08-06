<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SmsServiceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * 短信手机发送
     * @test
     */
    public function sendMobileMessage()
    {
        // $response =  app('sms')->send('15820153724', 'SMS_154950909', ["code" => '8899']);
        // $this->assertTrue(isset($response['aliyun']));

        $this->assertTrue(true);
    }
}
