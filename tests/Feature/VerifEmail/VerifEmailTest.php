<?php

namespace Tests\Feature\VerifEmail;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VerifEmailTest extends TestCase
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
    public function test_send_code_verification(): void
    {
        $response = $this->get('/email/verifikasi');

        $response->assertJson(['success' => 'Kami telah mengirimkan verifikasi cek email ada']);
    }

    public function test_verif_email_error()
    {
        $response = $this->get('email/verifikasi/aa0c5db8-5db6-4882-ada4-a055a577cbb');
        $response->assertRedirect('/register');
    }

    public function test_verif_email()
    {
        $response = $this->get('email/verifikasi/aa0c5db8-5db6-4882-ada4-a055a577cbb8');
        $response->assertRedirect('/home');
    }
}
