<?php

namespace Tests\Feature\ChangePassword;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ForgetPasswordTest extends TestCase
{
    // protected function setUp(): void
    // {
    //     parent::setUp();
    //     $user = User::latest()->first();
    //     $this->actingAs($user);
    // }

    /**
     * A basic feature test example.
     */
    public function test_forget_password_page(): void
    {
        $response = $this->get('/verif-email-changePassword');

        $response->assertStatus(200);
    }

    public function test_send_code_to_email_error()
    {
        $response = $this->post('/verif-email-changePassword', [
            'email' => 'evan.kusyanto@students.amikom.ac',
        ]);
        $response->assertStatus(302);
    }

    public function test_send_code_to_email_success()
    {
        $response = $this->post('/verif-email-changePassword', [
            'email' => 'evan.kusyanto@students.amikom.ac.id',
        ]);
        $response->assertStatus(302);
    }
}
