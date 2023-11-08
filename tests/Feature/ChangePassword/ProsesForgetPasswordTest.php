<?php

namespace Tests\Feature\ChangePassword;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProsesForgetPasswordTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_feature_change_password()
    {
        $response = $this->post('/changePassword', [
            'verif_code' => 'RYyF7cPMdjLEblRGhzYAFQ4zvRSqAHpYDNzw1YhQoXfoCmo2SpYFahxJrwQr',
            'password' => 'tes123',
            'repeat_password' => 'tes123',
        ]);
        $response->assertRedirect('/login');
    }
}
