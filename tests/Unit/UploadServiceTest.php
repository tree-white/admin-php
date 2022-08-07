<?php

namespace Tests\Unit;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UploadServiceTest extends TestCase
{
    /**
     * 用户头像上传
     * @test
     */
    public function userAvatarUpload()
    {
        $file = UploadedFile::fake()->image('avatar.jpeg', 100, 100);
        $res = app('upload')->avatar($file);
        $this->assertArrayHasKey('url', $res);
    }
}
