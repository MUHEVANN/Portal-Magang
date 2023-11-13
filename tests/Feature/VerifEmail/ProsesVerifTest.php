<?php

namespace Tests\Feature\ProsesVerif;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProsesVerifTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $user = User::find(17);
        $this->actingAs($user);
    }

    /**
     * A basic feature test example.
     */
    public function test_verif_email_error()
    {
        $response = $this->get('email/verifikasi/3929d090-f557-4379-8646-21189961c40');
        $response->assertRedirect('/register');
    }

    public function test_verif_email()
    {
        $response = $this->get('email/verifikasi/3929d090-f557-4379-8646-21189961c40f');
        $response->assertRedirect('/home');
    }
}