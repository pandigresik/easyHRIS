<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Base\Setting;

class SettingApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_setting()
    {
        $setting = Setting::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/base/settings', $setting
        );

        $this->assertApiResponse($setting);
    }

    /**
     * @test
     */
    public function test_read_setting()
    {
        $setting = Setting::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/base/settings/'.$setting->id
        );

        $this->assertApiResponse($setting->toArray());
    }

    /**
     * @test
     */
    public function test_update_setting()
    {
        $setting = Setting::factory()->create();
        $editedSetting = Setting::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/base/settings/'.$setting->id,
            $editedSetting
        );

        $this->assertApiResponse($editedSetting);
    }

    /**
     * @test
     */
    public function test_delete_setting()
    {
        $setting = Setting::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/base/settings/'.$setting->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/base/settings/'.$setting->id
        );

        $this->response->assertStatus(404);
    }
}
