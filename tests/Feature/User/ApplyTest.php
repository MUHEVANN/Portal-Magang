<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApplyTest extends TestCase
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
    public function test_apply_page(): void
    {
        $response = $this->get('/apply-form');

        $response->assertStatus(200);
    }

    // public function test_apply_error_required()
    // {
    //     $response = $this->post('apply-form', []);
    //     $response->assertStatus(302);
    //     $this->assertTrue(session('errors')->has('cv_pendaftar'));
    //     $this->assertTrue(session('errors')->has('job_magang_ketua'));
    // }

    public function test_apply_error_notverified()
    {
        $response = $this->post('apply-form', [
            'cv_pendaftar' => 'cv_user.pdf',
            'job_magang_ketua' => 1,
        ]);
        $response->assertStatus(302);
        $this->assertTrue(session()->has('error'));
        $this->assertEquals('Akun anda belum diverifikasi, cek email anda', session('error'));
    }
}
