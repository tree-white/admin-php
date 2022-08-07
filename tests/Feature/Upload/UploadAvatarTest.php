<?php

namespace Tests\Feature\Upload;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UploadAvatarTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * 未登录用户不允许上传
     * @test
     */
    public function notLoggedInUserIsNotAllowedToUpload()
    {
        $response = $this->postJson('/api/upload/avatar', []);
        $response->assertStatus(401);
    }

    /**
     * 上传文件不能为空
     * @test
     */
    public function uploadFilesCantBeEmpty()
    {
        $this->signIn();
        $response = $this->postJson('/api/upload/avatar', []);
        $response->assertStatus(422)->assertJsonValidationErrors('file');
    }

    /**
     * 头像必须为图片类型
     * @test
     */
    public function headMustTypeForThePicture()
    {
        $this->signIn();
        $response = $this->postJson('/api/upload/avatar', [
            'file' => UploadedFile::fake()->create('a.txt', 500),
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors('file');
    }

    /**
     * 头像大小限制
     * @test
     */
    public function headSizeLimit()
    {
        $this->signIn();
        $response = $this->postJson('/api/upload/avatar', [
            'file' => UploadedFile::fake()->image('a.jpeg', 20, 20),
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors('file');
    }

    /**
     * 头像上传成功
     * @test
     */
    public function avatarUploadedSuccessfully()
    {
        $this->signIn();
        $response = $this->postJson('/api/upload/avatar', [
            'file' => UploadedFile::fake()->image('a.jpeg', 600, 600)
        ]);
        $response->assertStatus(200)->assertJson(['url' => true]);
    }
}
