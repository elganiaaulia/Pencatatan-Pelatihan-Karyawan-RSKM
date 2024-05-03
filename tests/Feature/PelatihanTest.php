<?php

namespace Tests\Feature;

use App\Models\KaryawanPerPeriode;
use App\Models\PelatihanWajibPerPeriode;
use App\Models\User;
use App\Models\Periode;
use App\Models\RiwayatPelatihan;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PelatihanTest extends TestCase
{
    // use WithFaker;

    // public function test_user_can_create_pelatihan()
    // {
    //     $periode = Periode::factory()->create([
    //         'periode_name' => $this->faker->year(),
    //         'status' => 1,
    //     ]);
    //     $user = User::factory()->create([
    //         'role_id' => 2,
    //     ]);
    //     $response = $this->actingAs($user)->post(route('pencatatan.store', $periode->periode_name), 
    //     [
    //         'wajib' => $this->faker->randomElement([0, 1]),
    //         'nama_pelatihan' => $this->faker->sentence(),
    //         'nama_penyelenggara' => $this->faker->company(),
    //         'tgl_mulai' => '2024-03-30T13:35',
    //         'tgl_selesai' => '2024-03-30T18:35',
    //     ]);
    //     $response->assertRedirectToRoute('pencatatan.show', $periode->periode_name)->assertSessionHas('success');
    // }

    // public function test_user_can_view_percentage_pelatihan_after_added()
    // {
    //     $periode = Periode::factory()->create([
    //         'periode_name' => $this->faker->year(),
    //         'status' => 1,
    //     ]);
    //     $user = User::factory()->create([
    //         'role_id' => 2,
    //     ]);
        
    //     $data_pelatihan = [
    //         'wajib' => $this->faker->randomElement([0, 1]),
    //         'nama_pelatihan' => $this->faker->sentence(),
    //         'nama_penyelenggara' => $this->faker->company(),
    //         'tgl_mulai' => '2024-03-30T13:35',
    //         'tgl_selesai' => '2024-03-30T18:35', //5 jam
    //     ];
    //     $response = $this->actingAs($user)->post(route('pencatatan.store', $periode->periode_name), $data_pelatihan);
    //     $response->assertRedirectToRoute('pencatatan.show', $periode->periode_name)->assertSessionHas('success');

    //     $check_percentage = $this->actingAs($user)->get(route('pencatatan.show', $periode->periode_name));
    //     $check_percentage->assertSeeText('0%');
    // }

    // public function test_user_can_view_pelatihan_that_has_been_validated()
    // {
    //     $periode = Periode::factory()->create([
    //         'periode_name' => $this->faker->year(),
    //         'status' => 1,
    //     ]);
    //     $user = User::factory()->create([
    //         'role_id' => 2,
    //     ]);
    //     $admin = User::factory()->create([
    //         'role_id' => 1,
    //     ]);
    //     $data_pelatihan = [
    //         'wajib' => $this->faker->randomElement([0, 1]),
    //         'nama_pelatihan' => $this->faker->sentence(),
    //         'nama_penyelenggara' => $this->faker->company(),
    //         'tgl_mulai' => '2024-03-30T13:35',
    //         'tgl_selesai' => '2024-03-30T18:35', //5 jam
    //     ];
    //     $response = $this->actingAs($user)->post(route('pencatatan.store', $periode->periode_name), $data_pelatihan);
    //     $response->assertRedirectToRoute('pencatatan.show', $periode->periode_name)
    //     ->assertSessionHas('success');

    //     $get_id_pelatihan = RiwayatPelatihan::where('nama_pelatihan', $data_pelatihan['nama_pelatihan'])->first();
    //     $this->actingAs($admin)->get(route('pelatihan.show', $get_id_pelatihan->id));
        
    //     $check_percentage = $this->actingAs($user)->get(route('pencatatan.show', $periode->periode_name));
    //     $check_percentage->assertSeeText('2.5%');
    // }

    // public function test_admin_can_add_pelatihan_wajib()
    // {
    //     $admin = User::factory()->create([
    //         'role_id' => 1,
    //     ]);
    //     $periode = Periode::factory()->create([
    //         'periode_name' => $this->faker->year(),
    //         'status' => 1,
    //     ]);
    //     $response = $this->actingAs($admin)->post(route('pelatihan.store'),
    //     [
    //         'periode_id' => $periode->periode_name,
    //         'nama_pelatihan' => $this->faker->sentence(),
    //     ]);
    //     $response->assertSessionHas('success');
    // }

    // public function test_admin_can_delete_pelatihan_wajib()
    // {
    //     $admin = User::factory()->create([
    //         'role_id' => 1,
    //     ]);
    //     $periode = Periode::factory()->create([
    //         'periode_name' => $this->faker->year(),
    //         'status' => 1,
    //     ]);
    //     $response = $this->actingAs($admin)->post(route('pelatihan.store'),
    //     [
    //         'periode_id' => $periode->periode_name,
    //         'nama_pelatihan' => 'Pelatihan Wajib Test',
    //     ]);
    //     $response->assertSessionHas('success');
        
    //     $get_id_pelatihan = PelatihanWajibPerPeriode::where('nama_pelatihan', 'Pelatihan Wajib Test')->first();
    //     $response = $this->actingAs($admin)->delete(route('pelatihan.destroy', $get_id_pelatihan->id));
    // }

    // public function test_admin_can_view_sum_of_karyawan_that_not_reach_target()
    // {
    //     $periode = Periode::factory()->create([
    //         'periode_name' => $this->faker->year(),
    //         'status' => 1,
    //     ]);
    //     $user = User::factory()->create([
    //         'role_id' => 2,
    //     ]);
    //     $admin = User::factory()->create([
    //         'role_id' => 1,
    //     ]);
    //     $data_pelatihan = [
    //         'wajib' => $this->faker->randomElement([0, 1]),
    //         'nama_pelatihan' => $this->faker->sentence(),
    //         'nama_penyelenggara' => $this->faker->company(),
    //         'tgl_mulai' => '2024-03-30T13:35',
    //         'tgl_selesai' => '2024-03-30T18:35', //5 jam
    //     ];
    //     $response = $this->actingAs($user)->post(route('pencatatan.store', $periode->periode_name), $data_pelatihan);
    //     $response->assertRedirectToRoute('pencatatan.show', $periode->periode_name)
    //     ->assertSessionHas('success');

    //     $check_target = $this->actingAs($admin)->get(route('pelatihan.grafik', $periode->periode_name))
    //     ->assertSeeText('Belum Terpenuhi')
    //     ->assertSeeText('1');
    // }

    // public function test_admin_can_view_sum_of_karyawan_that_reach_target()
    // {
    //     $periode = Periode::factory()->create([
    //         'periode_name' => $this->faker->year(),
    //         'status' => 1,
    //     ]);
    //     $user = User::factory()->create([
    //         'role_id' => 2,
    //     ]);
    //     $admin = User::factory()->create([
    //         'role_id' => 1,
    //     ]);
    //     $karyawan_per_periode = KaryawanPerPeriode::factory()->create([
    //         'user_id' => $user->id,
    //         'periode_id' => $periode->id,
    //         'persentase' => 100,
    //     ]);

    //     $response = $this->actingAs($admin)->get(route('pelatihan.grafik', $periode->periode_name))
    //     ->assertSeeText('Terpenuhi')
    //     ->assertSeeText('1'); 
    // }
}