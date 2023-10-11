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
        $response = $this->get('email/verifikasi/8624e24-e548-4425-bbac-2fd8f108d7f3');
        $response->assertRedirect('/register');
    }

    public function test_verif_email()
    {
        $response = $this->get('email/verifikasi/8624e24b-e548-4425-bbac-2fd8f108d7f3');
        $response->assertRedirect('/home');
    }
}
