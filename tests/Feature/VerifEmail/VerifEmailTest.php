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
        $user = User::find(17);
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
}