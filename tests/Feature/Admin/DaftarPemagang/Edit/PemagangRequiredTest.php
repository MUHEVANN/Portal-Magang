<?php

namespace Tests\Feature\Admin\DaftarPemagang\Edit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        $response = $this->put('/edit-pemagang/7', []);

        $response->assertRedirect('/');
        $this->assertEquals('nama wajib diisi', session('errors')->first('name'));
        $this->assertEquals('email wajib diisi', session('errors')->first('email'));
    }
}
