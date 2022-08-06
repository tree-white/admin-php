<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Config::create([
            'site' => [
                'name' => '木白',
                'tel' => '13800138000',
                'icp' => '',
                'keywords' => '',
                'address' => '',
                'email' => '',
                'author' => ''
            ],
            'yunpian' => [
                'api_key' => env('YUNPIAN_API_KEY'),
            ],
            'aliyun' => [
                'access_key_id' => env('ALIYUN_ACCESS_KEY_ID'),
                'access_key_secret' => env('ALIYUN_ACCESS_KEY_SECRET'),
                'sms' => [
                    'sign_name' => env('ALIYUN_SMS_SIGN_NAME'),
                ],
            ],
        ]);
    }
}
