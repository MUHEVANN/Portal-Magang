<?php

namespace Tests\Feature\User\Profile;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SuccessProfileTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $user = User::where('id', 5)->first();
        $this->actingAs($user);
    }
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->post('/update-profile', [
            'name' => 'bambang',
            'email' => 'monroe.von@example.com',
        ]);

        $response->assertJson(['success' => 'update profile berhasil']);
    }
}
