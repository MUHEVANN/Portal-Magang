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
        $response = $this->put('/edit-pemagang/1', [
            'name' => 'evan',
            'email' => 'evan.kusyanto@students.amikom.ac.id',
            'carrer_id' => 12,
            'tgl_mulai' => now(),
            'tgl_selesai' => now()->addDays(100),
            'job_magang_id' => 6,
            'cv_user' => 'uk8w3zGCVV.pdf',
        ]);
        $response->assertJsonFragment(['success' => 'Berhasil Mengupdate']);
    }
}
