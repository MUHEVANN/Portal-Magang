<?php

namespace Tests\Feature\Admin\Lowongan\Error;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateRequiredTest extends TestCase
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
        $response = $this->post('/lowongan', [
            'gambar' => 'gambar.jpg',
            'desc' => 'required',
            'kualifikasi' => 'required',
            'benefit' => 'required',
            'deadline' => now()->addDays(40)
        ]);

        $response->assertJsonStructure([
            'error' => [
                'name' //Field error.
            ]
        ]);
    }
}
