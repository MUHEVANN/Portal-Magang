<?php

namespace Tests\Feature\Admin\Lowongan\Error;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PutRequiredTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $user = User::where('name', 'Admin')->first();
        $this->actingAs($user);
    }
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->post('/lowongans/1', [
            'gambar' => 'gambar.jpg',
            'desc' => 'required',
            'kualifikasi' => 'required',
            'benefit' => 'required',
            'deadline' => now()->addDays(40)
        ]);
        $response->assertJsonFragment(['name' => ['Nama tidak boleh kosong']]);
        // $response->assertJsonFragment(['desc' => ['Descripsi tidak boleh kosong']]);
        // $response->assertJsonFragment(['kualifikasi' => ['Kualifikasi tidak boleh kosong']]);
        // $response->assertJsonFragment(['benefit' => ['Benefit tidak boleh kosong']]);
        // $response->assertJsonFragment(['deadline' => ['deadline tidak boleh kosong']]);

    }
}
