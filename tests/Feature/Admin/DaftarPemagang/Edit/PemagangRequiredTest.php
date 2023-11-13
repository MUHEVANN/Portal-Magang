<?php

namespace Tests\Feature\Admin\DaftarPemagang\Edit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PhpParser\Node\Expr\Error;
use Tests\TestCase;

class PemagangRequiredTest extends TestCase
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
            'carrer_id' => 12,
            'tgl_mulai' => now(),
            'tgl_selesai' => now()->addDays(30)
        ]);
        // $response->assertRedirect('/');
        $response->assertJsonFragment(['name' => ['nama wajib diisi']]);
        $response->assertJsonFragment(['email' => ['email wajib diisi']]);
        $response->assertJsonFragment(['job_magang_id' => ['job magang wajib diisi']]);
    }
}
