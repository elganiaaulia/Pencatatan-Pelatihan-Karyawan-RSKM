<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $explode = explode(" ", $row[0]);
        $email = $explode[0] . '.' . $row[1];
        $existing_mail = User::where('email', $email)->first();
        $existing_nik = User::where('NIK', $row[1])->first();

        if($existing_mail || $existing_nik || $row[0] == null || $row[1] == null){
            return null;
        }

        $hash_password = Hash::make($row[1]);

        return new User([
            'role_id' => 2,
            'full_name' => $row[0],
            'NIK' => $row[1],
            'email' => $email,
            'password' => $hash_password,
            'unit' => $row[2],
        ]);
    }
}
