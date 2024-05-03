<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class Iterasi_1_Test extends TestCase
{
    public function test_user_can_login_with_valid_credentials()
    {
        $password = '1234567';
        $user = User::factory()->create([
            'role_id' => 1,
            'password' => Hash::make($password),
        ]);

        $response = $this->post('/', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_invalid_email()
    {
        $email = 'admin.12345678';
        $password = '123456789';
        $response = $this->post('/', [
            'email' => $email,
            'password' => $password,
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_user_cannot_login_with_invalid_password()
    {
        $email = 'admin.123456789';
        $password = '12345678';
        $response = $this->post('/', [
            'email' => $email,
            'password' => $password,
        ]);

        $response->assertSessionHasErrors('email');
    }
}
