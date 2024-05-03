<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    // use WithFaker;

    // public function test_admin_can_create_user()
    // {
    //     $user = User::factory()->create([
    //         'role_id' => 1,
    //     ]);
    //     $response = $this->actingAs($user)->post(route('users.store'), 
    //     [
    //         'full_name' => 'Test User',
    //         'NIK' => '1234567890',
    //         'email' => $this->faker->unique()->safeEmail(),
    //         'unit' => 'UGD Test',
    //         'role' => 2,
    //         'password' => 'password'
    //     ]);
    //     $response->assertRedirect(route('users.index'));
    // }

    // public function test_user_can_edit_account_password()
    // {
    //     $password = 'password';
    //     $password2 = 'secret';
    //     $user = User::factory()->create([
    //         'role_id' => 2,
    //         'password' => Hash::make($password),
    //     ]);
    //     $response = $this->actingAs($user)->put(route('karyawan.password.update', $user->id),
    //     [
    //         'password' => $password2,
    //         'confirm-password' => $password2,
    //     ]);
    //     $response->assertRedirect(route('karyawan.password'));
    // }

    // public function test_user_can_access_with_new_password()
    // {
    //     $password = 'password';
    //     $password2 = 'secret';
    //     $user = User::factory()->create([
    //         'role_id' => 2,
    //         'password' => Hash::make($password),
    //     ]);
    //     $response = $this->actingAs($user)->put(route('karyawan.password.update', $user->id),
    //     [
    //         'password' => $password2,
    //         'confirm-password' => $password2,
    //     ]);
    //     $login = $this->post('/', [
    //         'email' => $user->email,
    //         'password' => $password2,
    //     ]);

    //     $login->assertRedirect(route('karyawan.dashboard'));
    // }

    // public function test_user_can_not_access_with_old_password()
    // {
    //     $password = 'password';
    //     $password2 = 'secret';
    //     $user = User::factory()->create([
    //         'role_id' => 2,
    //         'password' => Hash::make($password),
    //     ]);
    //     $this->actingAs($user)->put(route('karyawan.password.update', $user->id),
    //     [
    //         'password' => $password2,
    //         'confirm-password' => $password2,
    //     ]);
    //     $this->get(route('logout'))->assertRedirect('/');
    //     $login = $this->post('/', [
    //         'email' => $user->email,
    //         'password' => $password,
    //     ]);
    //     $login->assertSessionHasErrors();
    //     $this->assertGuest();
    // }
}
