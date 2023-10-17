<?php

namespace Tests\Feature\ChangePassword;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $user = User::latest()->first();
        $this->actingAs($user);
    }

    /**
     * A basic feature test example.
     */
    public function test_change_password_page(): void
    {
        $response = $this->get('/changePassword');

        $response->assertStatus(200);
    }
    public function test_feature_change_password()
    {
        $response = $this->post('/ganti-password', [
            'password_lama' => 'tes',
            'password_baru' => 'tes123',
            'confirm_password' => 'tes123',
        ]);

        $response->assertStatus(200);
    }
}
