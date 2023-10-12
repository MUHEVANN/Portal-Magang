<?php

namespace Tests\Feature\Admin\DaftarPendaftar;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class KonfirmasiTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $user = User::where('id', 11)->first();
        $this->actingAs($user);
    }
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/pendaftar');

        $response->assertStatus(200);
    }
    public function test_lulus(): void
    {
        $response = $this->get('apply-status-konfirm/6');
        $response->assertRedirect('/pendaftar');
        $this->assertEquals('success', session('success'));
    }

    public function test_ditolak(): void
    {
        $response = $this->get('apply-status-reject/5');
        $response->assertRedirect('/pendaftar');
        $this->assertEquals('Apply job berhasil dikonfirmasi', session('success'));
    }
}
