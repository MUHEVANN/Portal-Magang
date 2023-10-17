<?php

namespace Tests\Feature\User\Apply;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ErrorApplyedTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $user = User::where('id', 7)->first();
        $this->actingAs($user);
    }
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->post('/apply-form', [
            'job_magang_ketua' => 1,
            'cv_pendaftar' => 'evan.pdf',
        ]);
        $response->assertStatus(302);
        $this->assertEquals('Anda sudah melakukan Apply, silahkan tunggu konfirmasi dari kami', session('error'));
    }
}
