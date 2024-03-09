<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'id' => 1,
                'role_id' => 1,
                'email' => 'admin.123456789',
                'full_name' => 'Admin 1',
                'NIK' => '123456789',
                'password' => Hash::make('123456789'),
                'unit' => 'Admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'role_id' => 2,
                'email' => 'karyawan.1234567890',
                'full_name' => 'Karyawan 1',
                'NIK' => '1234567890',
                'password' => Hash::make('1234567890'),
                'unit' => 'UGD',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        User::query()->insert($users);
    }
}
