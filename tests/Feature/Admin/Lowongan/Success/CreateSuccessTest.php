<?php

namespace Tests\Feature\Admin\Lowongan\Success;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateSuccessTest extends TestCase
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
            'name' => 'back end ',
            'gambar' => new \Illuminate\Http\UploadedFile(storage_path('app/public/lowongan/3d16d158-a9ef-418b-b62f-9bfe2fa3ed81.jpg'), '3d16d158-a9ef-418b-b62f-9bfe2fa3ed81.jpg', 'image/jpeg', null, true),
            'desc' => 'required',
            'kualifikasi' => 'required',
            'benefit' => 'required',
            'deadline' => now()->addDays(40)
        ]);
        // $response->assertJsonFragment(['error' => ['gambar' => ['Gambar harus bertipe jpg/png/jpeg/svg']]]);
        $response->assertJsonFragment(['success' => 'Berhasil menambah lowongan']);
    }
}
