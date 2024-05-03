<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class Iterasi_4_Test extends TestCase
{
    public function test_user_can_access_information_with_valid_credentials()
    {
        $password = '12345';
        $user = User::factory()->create([
            'role_id' => 1,
            'password' => Hash::make($password),
        ]);
        $response = $this->actingAs($user)->get(route('admin.dashboard'));
        $response->assertOk();
        $response->assertViewIs('dashboard');
        $response->assertSeeText('Informasi');
    }

    public function test_admin_can_upload_information_with_valid_credentials()
    {
        $user = User::factory()->create([
            'role_id' => 1,
        ]);
        $response = $this->actingAs($user)->post(route('update.tinymce'), 
        [
            'info_desc' => 'This is a test information description',
        ]);
        $response->assertSessionDoesntHaveErrors('info_desc');
        $response->assertSeeText('This is a test information description');
    }
}
