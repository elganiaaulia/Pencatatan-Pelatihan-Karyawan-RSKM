<?php

namespace Tests\Feature;

use App\Models\Periode;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PeriodeTest extends TestCase
{
    // use WithFaker;
    // public function test_admin_can_access_index_periode_table()
    // {
    //     $user = User::factory()->create([
    //         'role_id' => 1,
    //     ]);
    //     $response = $this->actingAs($user)->get(route('periode.create'));
    //     $response->assertOk();
    //     $response->assertViewIs('user_type.auth.periode.create');
    //     $response->assertSeeText('Periode Terdaftar');
    // }

    // public function test_admin_can_create_periode()
    // {
    //     $user = User::factory()->create([
    //         'role_id' => 1,
    //     ]);
    //     $response = $this->actingAs($user)->post(route('periode.store'), 
    //     [
    //         'periode_name' => $this->faker->year(),
    //     ]);
    //     $response->assertRedirect(route('periode.create'))->assertSessionHas('success');
    // }

    // public function test_admin_can_edit_periode()
    // {
    //     $user = User::factory()->create([
    //         'role_id' => 1,
    //     ]);
    //     $periode = Periode::factory()->create();
    //     $response = $this->actingAs($user)->get(route('periode.update', $periode->id),
    //     [
    //         'periode_name' => $this->faker->year(),
    //     ]);
    //     $response->assertRedirect(route('periode.create'))->assertSessionHas('success');
    // }

    // public function test_admin_can_delete_user()
    // {
    //     $user = User::factory()->create([
    //         'role_id' => 1,
    //     ]);
    //     $periode = Periode::factory()->create();
    //     $response = $this->actingAs($user)->delete(route('periode.destroy', $periode->id));
    //     $response->assertRedirect(route('periode.create'))->assertSessionHas('success');
    // }
}
