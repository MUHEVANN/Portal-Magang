<?php

namespace Tests\Feature\Admin\DaftarPemagang\Edit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PemagangEditSuccessTest extends TestCase
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
        $response = $this->put('/edit-pemagang/6', [
            'name' => 'Evan K',
            'email' => 'evankusyanto05@gmail.com',
            'password' => 'password',
            'alamat' => 'Sendangan',
            'no_hp' => '0289302',
            'gender' => 'L',
            'carrer_id' => 2,
            'tgl_mulai' => now(),
            'tgl_selesai' => now()->addDays(100),
            'job_magang_id' => 2
        ]);


        $response->assertJsonFragment(['success' => 'Berhasil Mengupdate']);
    }
}
